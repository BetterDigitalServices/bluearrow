<?php if (!defined('ABSPATH') ) die(); ?>
<table class="arevico-table">
	<thead>
		<tr>
			<th>Target</th>
			<th>Redirect</th>
			<th></th>
		</tr>
	</thead>	

	<tbody>
	<?php FOREACH ($targets as $target): ?>

		<tr style="border-bottom:0;">
			<td class="large">
				<input type="text" name="o[target][<?php echo $target->id; ?>][url]" value="<?php ArevicoSQA::val('url', $target, true, true, 'http://'); ?>"></td>
			<td class="medium">
				<select name="o[target][<?php echo $target->id; ?>][redirect_type]" id="">
					<option value="307" <?php $this->_s('redirect_type', $target, '307'); ?>>307 - Moved Temporary</option>
					<option value="301" <?php $this->_s('redirect_type', $target, '301'); ?>>301 - Moved Permanent (SEO)</option>
				</select>
			</td>
			<td>

			</td>
		</tr>

	<?php ENDFOREACH; ?>
	</tbody>
</table>