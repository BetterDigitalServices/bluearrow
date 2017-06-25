<?php if (!defined('ABSPATH')) die();?>


<div class="wrap arevico">
	<form action="?page=wp-simple-redirect" method="POST">

<?php if ( ArevicoSQA::isPost() ): ?>
	<div class="update-success fade-out">
		<p>Settings Saved Successfully!</p>
	</div>
<?php ENDIF; ?>

<?php $this->section('admin.infobar'); ?>


<div class="grid">

		<?php $this->getTabHeader(array('tab-general' => 'General', 'tab-variables' => 'Link Variables')) ?>

	<div class="tab tab-active" id="tab-general">
		<?php $this->section('admin.global-tab-general', get_defined_vars() ); ?>
	</div>
	
	<div class="tab" id="tab-variables">
		<?php $this->section('admin.global-tab-variables', get_defined_vars() ); ?>
	</div>
	<?php $this->closeTab(); ?>

	<div class="row">
		<div class="col2">&nbsp;</div>
		<div class="col4">
			<input type="submit" class="save-button page-title-action" value=" Save Settings! ">
		</div>
		<div class="col6 col-sr"></div>
	</div>


</div> <!-- end grid -->
</form>
</div>

