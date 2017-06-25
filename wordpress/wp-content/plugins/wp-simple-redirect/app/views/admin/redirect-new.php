<?php if (!defined('ABSPATH') ) die(); ?>

<div class="wrap arevico">

<?php if ( ArevicoSQA::isPost() ): ?>
	<div class="update-success fade-out">
		<p>Settings Saved Successfully!</p>
	</div>
<?php ENDIF; ?>

<?php $this->section('admin.infobar'); ?>

	<h1>Link <a href="?page=wp-simple-redirect-new" class="page-title-action"> Add New</a></h1>
	<br />
	<form action="?page=wp-simple-redirect-new<?php $this->idUrl( $id ); ?>" method="POST">
		<?php $this->nonceField(); ?>
		<?php $this->idField( $id ); ?>

		<div class="grid">

			<!-- Name -->
			<div class="row">
				<div class="col2 label">Name</div>
				<div class="col7">
					<input type="text" name="o[name]" value="<?php $this->_v('name', $o); ?>" placeholder="Simple Short Link #1">
				</div>
				<div class="col3 col-sr"></div>
			</div>

			<!-- Slug -->
			<div class="row">
				<div class="col2 label">Slug</div>
				<div class="col-min text-right">
					<?php echo htmlentities(rtrim(get_site_url() , '/') ) , '/' , ltrim(ArevicoSQA::val('global_prefix', $globalOptions, false, true) , '/'); ?> &nbsp;
				</div>
				<div class="col">
					<input type="text" name="o[slug]" value="<?php $this->_v('slug', $o); ?>" placeholder="out/your-special-link">
				</div>
				<div class="col3 col-sr"></div>
			</div>

			<!-- Tip -->
			<div class="row">
			<div class="col2">&nbsp;</div>
				<div class="col7">
					<p class="italic">Be mindfull when including trailing or leading slashes! Leading slashes in the request will be removed if no query parameters (f.e. '?id=2&user-arevico') are given </p>
				</div>
				<div class="col3 col-sr"></div>
			</div>

	
			<div class="row">
				<div class="col2 label">Match Type</div>
				<div class="col4">
					<select name="o[match_type]" id="">
						<option value="0" <?php $this->_s('match_type', $o, '0'); ?> >Starts With</option>
						<option value="1" <?php $this->_s('match_type', $o, '1'); ?>>Equals</option>
						<option value="2" <?php $this->_s('match_type', $o, '2'); ?>>Contains</option>
						<option value="3" <?php $this->_s('match_type', $o, '3'); ?>>Regular Expression</option>
					</select>

				</div>
				<div class="col3"></div>
				<div class="col3-sr"></div>
			</div>
			<div class="row">
			<div class="col2">&nbsp;</div>
				<div class="col7">
					<input data-grey-if-not="#enable-regex" value="1" type="checkbox" name="o[encode]" <?php $this->_c('encode', $o); ?> id=""> 
					<span class="italic"> URL Encode the captured text (regex capture groups). You can use {$1} to include a capture group.</span>
				</div>
				<div class="col3 col-sr"></div>
			</div>

			<!-- Targets  -->
			<div class="row">
				<div class="col2 label"></div>
				<div class="col10">
					<?php $this->section('admin.tables.Targets', get_defined_vars() ); ?>
				</div>
			</div>


		<div class="row">
			<div class="col2"></div>
			<div class="col4">
				<input type="submit" class="page-title-action save-button" value=" Save Settings">
			</div>
			<div class="col6 col-sr"></div>
		</div>


		</div> <!-- end grid -->
</form>


</div>