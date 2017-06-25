<?php
if (!class_exists('ArevicoUpdateInfo')){

/**
 * This class automatically processes post variables into corresponding actions
 *
 * @package Core/Helper
 * @version 1.0
 */   
class ArevicoUpdateInfo{

	/** Public properties*/
	public $insert 		= array();
	public $delete 		= array();
	public $update 		= array();

    /**
     * Initialize an Arevico Update Info Object
     *
     * @param string $update_path path to the array containing all update rows e.g customer->addresses
     * @param string $delete_path path to the array where all deleted items are stored e.g. customer->delete_phone
     * @param array $postArray the base array containing all the form elements submitted by the user.
     *          (default to $_POST, if null)
     */
	public function __construct( $update_path, $delete_path = null, $postArray = null){
		$arr_update    = ArevicoSQA::oVal($update_path, $postArray, array() );

        if ($delete_path !== null)
                $this->delete = ArevicoSQA::oVal( $delete_path, $postArray , array() );

		// Assign to the correct public property
         foreach ($arr_update as $key => $val) {

            if ( strpos($key,'insert')===0) {
                $this->insert[] = $val;

             } elseif (strpos($key,'{id}')===0){
                 
             // Template Row, ignore
             } else {
                 $this->update[$key] = $arr_update[$key];
             }
         }

         return $this;
	}

}

} // End Class Exists Check