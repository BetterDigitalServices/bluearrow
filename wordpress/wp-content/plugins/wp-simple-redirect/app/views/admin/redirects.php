<?php if (!defined('ABSPATH') )die(); ?>


 <div class="wrap">

	<?php $this->section('admin.infobar'); ?>

	<h1>Redirects <a href="?page=wp-simple-redirect-new" class="page-title-action">Add New</a></h1>

	<?php 
		$redirectsTable->setView($this)->render(); 
	?>

</div>