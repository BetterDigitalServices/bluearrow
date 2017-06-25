<div class="row">
	<div class="col2 label">Global Prefix</div>
	<div class="col4">
		<input name="o[global_prefix]" type="text" placeholder="/out/" value="<?php $this->_v('global_prefix', $o, '/out/'); ?>" />
	</div>
	<div class="col6 col-sr"></div>
</div>

<div class="row">
	<div class="col2 label"></div>
	<div class="col7">
		<p>Can be empty, but redirect will be faster when all slugs are prefixed!</p>
	</div>
	<div class="col3 col-sr"></div>
</div>

<div class="row">
	<div class="col2 label">Not Found Redirect</div>
	<div class="col4">
		<input name="o[global_404]" type="text" placeholder="http://" value="<?php $this->_v('global_404', $o, 'http://'); ?>" />
	</div>
	<div class="col6 col-sr"></div>
</div>

<div class="row">
	<div class="col2 label"></div>
	<div class="col7">
		<p>If the Prefix is found, but we couldn't find a target to redirect too, redirect to this URL.</p>
	</div>
	<div class="col3 col-sr"></div>
</div>
