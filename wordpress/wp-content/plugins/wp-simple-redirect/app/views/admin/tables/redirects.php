<?php
/**
 * 
 */
class arvalRedirectsTable extends ArevicoTable
{

	public function get_columns(){
		return array(
		    'cb'        => '<input type="checkbox" />',
    		'name' 		=>	'Name',
			'slug'		=> 'URL'
		);
	}

	/*
	public function column_enabled( $item ){
		return '<select><option>Enabled</option><option>Disabled</option></select>';
	}*/
	
	public function column_name($item){
		$item 		= (array)$item;
		$editLink 	= sprintf('<a href="?page=wp-simple-redirect-new&id=%1$s">Edit</a>', $item['id']);

		$actions 	= array(
		    'edit'      => $editLink,
            'delete'    => sprintf('<a class="confirm" href="?page=wp-simple-redirect-overview&delete=%1$s%2$s">Delete</a>'
			, $item['id'], 
			$this->getView()->nonceUrl(false) )	
        );

		$name 			= sprintf('<a class="row-title" href="%2$s">%1$s</a>',
									htmlentities($item['name']) ,
									"?page=wp-simple-redirect-new&id=" . $item['id']
									);
		return $name . $this->row_actions($actions);
	}

	public function column_slug( $item ){
		$slug 		 = ArevicoSQA::val('slug', $item) ;
		$site 		 = rtrim( get_site_url(), '/');
		$options 	 = $this->getView()->getData('globalOptions');
		$slug 		 = ltrim(ArevicoSQA::val('global_prefix', $options) , '/')  . $slug;

		return $site . "<strong>/{$slug}</strong>";
	}

	public function column_default($item, $column){
		return '123';
	}	


	public function display_tablenav( $which ){
		return '';
	}
}
