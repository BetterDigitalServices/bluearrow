<?php
/**
 * 
 */
class arvalTargetModel extends ArevicoDBModel
{

	protected $_fillable 	= array('url', 'redirect_type', 'redirect_id');
	protected $_bools 		= array('');

	/**
	 * Get redirect belonging to thi starget
	 *
	 * @param int $redirectId 
	 */
	public function redirect( $redirectId ){
		$prefix 	= $this->getRegistry()->getDBPrefix();

		$this->delayQuery();
		$this->all();
		$this->getDB()->query['SELECT'] = 't.*';
		$this->getDB()->query['FROM'] = "{$prefix}targets t, {$prefix}redirects r";
		$this->getDB()->query('WHERE', 'r.id = redirect_id AND r.id = "' . esc_sql($redirectId) . '"' );
		return $this->getDB()->getResults();
	}

	public function update( $redirectId, $updateInfo){
		if ($redirectId == null || !$this->validateData( $updateInfo ) )
			return false;

		foreach ($updateInfo->insert as $row) 
			parent::insert( array_merge($row, array('redirect_id' => $redirectId) ));			
	
		foreach ($updateInfo->update as $id => $row) 
			parent::update( $id, array_merge($row, array('redirect_id' => $redirectId) ));			

		if (!empty($updateInfo->delete))
			parent::delete($updateInfo->delete);
	}

	public function validateData(){
		return true;
	}

	/**
	 *
	 * @param string|array $redirectId
	 * @param string $extraConditions ignored
	 */
	public function deleteWhere($redirectId, $extraConditions = null) {
		global $wpdb;
		return parent::delete(null, $wpdb->prepare('redirect_id = %s ', $redirectId) );
	}

	function __construct( $reg )
	{
		parent::__construct( $reg );
		$this->_db 	= new ArevicoDB( $reg );
		$this->_db->setTable('targets');
	}
}
