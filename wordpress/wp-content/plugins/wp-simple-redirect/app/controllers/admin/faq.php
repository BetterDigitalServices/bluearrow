<?php
/**
 * Frequently Asked Questions
 *
 *
 */
/**
 * 
 */
class arvalFaqController extends ArevicoController
{
	
	/**
 	 * Render The FAQ Section
	 */
	 public function render(){
		 $view = $this->makeView('admin.faq');
		 $view->render();
		 return true;
	 }
	
}
