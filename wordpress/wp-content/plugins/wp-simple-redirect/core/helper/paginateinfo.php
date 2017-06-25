<?php
 if (!class_exists('ArevicoPaginateInfo')) {

/**
 * Class Object containing pagination data
 *
 * @package Core/Helper
 * @version 1.0
 */
class ArevicoPaginateInfo{

	public $paged 		= 1;
	public $per_page 	= 20;
	public $items 		= null;

	/**
	 * Return the amount of pages
	 *
	 * @return int return 1 or higher
	 */
	public function getNumberOfPages(){
		return  ceil($this->items / $this->per_page);
	}

}

} // End Class Exists Check