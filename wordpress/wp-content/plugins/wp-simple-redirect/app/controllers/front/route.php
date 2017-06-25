<?php
/**
 * 
 */
class arvalRouteController extends ArevicoController
{
	
	/** The Current URL*/
	protected $_url 		= '';
	protected $_options		= null;


	/** Set the replacement string here for preg-replace-callback */
	private $_replacement = '';

	/**
	 * Re-route any rewritten url according to the settings specified in the admin screen
	 *
	 * @param WP_Query $query the current query object (not fully set yet)
	 */
	public function route( $query ){
		$o 	= $this->_options;

		if (!$this->checkGlobalPrefix())
			return false;

		// Get all links
		$links 	= $this->makeModel('Redirect');
		$links 	= $links->all();

		if (!$link 	= $this->getLinkMatch( $links ))
			return ( $this->redirectGlobalprefix( $o ) );

		if (!$target = $this->getLinkTarget( $link ))
			return false;

		/* Replace Variables */
		$target->url 	= $this->replaceVariables($target->url);
		$encode  		= ArevicoSQA::oVal('encode', $link);

		if ($link->match_type == 3)
			$target->url 	= $this->replaceRegexCapture($target, $encode, $link->matches);

		/* Peform The Redirect*/
		if ( $target != null ){
			header("Location: {$target->url}",TRUE, $target->redirect_type);
			die();
		}

	}

	/**
	 * Redirect if:
	 * 	A Global Prefix is set AND
	 *	Global 404 is set AND
	 *
	 * @param array $o option array with options specifified as in Controller\GlobalOption
	 */
	private function redirectGlobalprefix( $o ){
		if (empty($o['global_prefix']) || empty($o['global_404']) ) 
			return;

		$url404  = $o['global_404'];
		// A tempoary redirect is used so that when we add URLs it works instantly
		header("Location: {$url404}",TRUE, '307');
		die();

	}

	/**
	 * For all the links added, check which one if one matches
	 *
	 * @param array<Links> $links the array of link objects
	 */
	private function getLinkMatch( $links ){

		foreach ($links as $redirectId => $link ) {
			$pattern  = '';

			/* Starts with */
			if ($link->match_type == 0){
				$pattern = '^' . preg_quote( $link->slug);

			/* Equals */
			} elseif( $link->match_type == 1 ){
				$pattern = '^' . preg_quote( $link->slug) . '$';

			/* Contains */
			} elseif( $link->match_type == 2 ){
				$pattern = preg_quote( $link->slug);

			/* RegEx */
			} elseif( $link->match_type == 3 ){
				$pattern = $link->slug;
	 		}
			
			$link->matches = array();
			if (preg_match('~' . $pattern . '~ism', $this->getUrl(), $link->matches ))
				return $link;
		}
	}

	/**
	 *
	 *
	 */
	private function getLinkTarget( $link ){
		$targets 	= $this->makeModel('target');
		$targets 	= $targets->findRelation('redirect_id', $link->id);

		$targetKey 		= ArevicoSQA::firstKey($targets);

		return $targets[ $targetKey ];
	}

	/**
	 * If a global prefix is set, check if it appears in the URL
	 *
	 */
	private function checkGlobalPrefix(){
		$globalPrefix 	= ArevicoSQA::oVal('global_prefix', $this->_options, '');
		$globalPrefix 	= strtolower( ltrim($globalPrefix, '/') );

		if  (  (!empty($globalPrefix))  && strpos(strtolower($this->_url), $globalPrefix  ) !==0 ) 
			return false; 

		// Remove the global prefix so we can check
		$this->_url = substr( $this->_url, strlen($globalPrefix) );

		return true;
	}

	
	/**
	 * Replace the common and system variables specified in the target url in the form of {$VARIABLE_NAME}
	 *
	 * @param string $url The current (partially) processed url
	 */
	private function replaceVariables( $url ){
		$o 			= get_option('arval_sl' , array() );
		$customVars	= ArevicoSQA::oVal('customVariables', $o, array());

		$vars 	= array(
			'rand' 	=> array(
				'value' 	=> rand(1,32766), 
				'encode' 	=> true
			),
			'ip' 	=> array( 
				'value' 	=> $_SERVER["REMOTE_ADDR"],
				'encode'	=> true
			)
		);

		// Add custom variables without overriding 'system' variables
		foreach ($customVars as $customVar){
			
			// Array keys are case sensitive while our replace query is not, lets match it!
			$varName 	= strtolower( $customVar['variable'] );
			if ( !isset($vars[ $varName])){
				$vars[ $varName ] = $customVar;
				$vars[ $varName ]['encode'] 	= ArevicoSqA::oVal('encode', $customVar, '0');
				}
		}

		foreach ($vars as $variable => $value) {
			$pattern 	= preg_quote('{$' . $variable . '}');

			$this->_replacement = $value['encode'] == 1 ? rawurlencode($value['value']) : $value['value'];
			$url 		= preg_replace_callback("~{$pattern}~ism", array($this, 'prHandler'), $url);
		}

		return $url;
	}

	/**
	 * A preg_replace_callback handler. It replace with a string instead of a evaluated regular expression
	 *
	 * @param array $matches The matches captured
	 * @param string $this->_replacement the replacement string 
	 */
	private function prHandler( $matches){
		return $this->_replacement;
	}

	/**
	 *
	 * @todo escape regex characters ~ and . and -
	 */
	private function replaceRegexCapture( $target, $encode, $matches ){
		foreach ($matches as $captureGroup => $captureValue) {
			$pattern 	= preg_quote('{$' . $captureGroup . '}');

			$this->_replacement = empty($encode)  ? $captureValue : rawurlencode($captureValue) ;
			$target->url 		= preg_replace_callback('~' . $pattern . '~ism', array( $this, 'prHandler' ), $target->url);
		}
	
 		return $target->url;
	}
	
	/**
	 *
	 *
	 */
	 public function getUrl(){
		return $this->_url;
	}

	/**
	 * Initialize the current URL variables, get options
	 *
	 */
	 function __construct( $reg )
	{
		parent::__construct( $reg );
			$url 	= ltrim($_SERVER['REQUEST_URI'], "/");
			$url 	= rtrim($url, '/');

			$this->_url 		= $url;
			$this->_options 	= get_option('arval_sl', array());
	}
}
