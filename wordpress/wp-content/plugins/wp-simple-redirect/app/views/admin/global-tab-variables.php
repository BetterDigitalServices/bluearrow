<div class="row">
	<div class="col2 label">Variables</div>
	<div class="col7 italic">
		<p>Variables are replaced in all <strong>shortened outgoing urls</strong>. This makes it easy to include common data like affililiate id.</p>
		<p>You can include variables entering <strong>{$variable}</strong> into the 'target url' fields, when making a new redirect.</p>
	</div>
	<div class="col2 col-sr"></div>
</div>


<div class="var-container" data-add-button=".add" data-prepend="true">

	<!-- Template Row-->
	<div class="row template hidden single-item">
		<div class="col3 label">&nbsp;</div>
		<div class="col2">
			<input type="text" name="o[customVariables][{id}][variable]" placeholder="variable">
		</div>
		<div class="col3">
			<input type="text" name="o[customVariables][{id}][value]" placeholder="value">
		</div>
		<div class="col2">
			<select name="o[customVariables][{id}][raw]" id="">
				<option value="0">Unescaped</option>
				<option value="1">Escaped</option>
			</select>
		</div>
		<div class="col2"><a href="#" class="delete page-title-action" data-id=""> x </a></div>
	</div>
	 <!-- /end template row -->

<?php $i=0; FOREACH ( $o['customVariables'] as $row  ): $i++; ?>

		<div class="row single-item">
			<div class="col3 label">
				<?php IF ($i == 1): ?> Custom Variables	<?php ENDIF; ?> 
			</div>
		
			<div class="col2">
				<input type="text" placeholder="variable" name="o[customVariables][<?php echo $i; ?>][variable]" value="<?php $this->_v('variable', $row); ?>" >
			</div>

			<div class="co3">
				<input type="text" name="o[customVariables][<?php echo $i; ?>][value]" placeholder="value" value="<?php $this->_v('value', $row); ?>" >
			</div>

			<div class="col2">
				<select name="o[customVariables][<?php echo $i; ?>][encode]" id="">
					<option value="0" <?php $this->_s('encode', $row, '0'); ?>>Raw</option>
					<option value="1" <?php $this->_s('encode', $row, '1'); ?>>URL Encode</option>
				</select>
			</div>

			<div class="col2">
				<?php IF( $i == 1 ):  ?>
					<a href="#" class="add page-title-action" data-test-1="200" data-test-2="300"> Add </a> 
				<?php ELSE:  ?>
					<a href="#" class="delete page-title-action"> x  </a> 	
				<?php ENDIF; ?>			
			</div>
		</div>

		<?php IF( $i == 1 ):  ?>
			<div class="custom-items">
		<?php ENDIF; ?>
		<!--  -->
		<?php IF ( $i == count( $o['customVariables'] ) ): ?> </div> <?php ENDIF; ?>

	<?php ENDFOREACH; ?>

</div>

	<!--  Save Button -->
	<div class="row">
		<div class="col2"></div>
		
		<div class="col4">
			<!-- <input class="page-title-action save-button" type="submit" value=" Save Settings " name="submit" /> -->
		</div>
		<div class="col2 col-sr"></div>
		<div class="col4 col-sr"></div>
	</div>
	<!-- end save button -->

<div class="row">
	<div class="col12">&nbsp;</div>
</div>

<div class="row">
	<div class="col3 label">
		System Variables
	</div>
	<div class="col3">
		<input type="text" value="rand" readonly>
	</div>
	<div class="col4">
		<input type="text" value="<?php echo rand(1,32766); ?>" readonly>
	</div>
	<div class="col2 col-sr"> </div>
</div>

<div class="row">
	<div class="col3 label">
		 
	</div>
	<div class="col3">
		<input type="text" value="ip" readonly>
	</div>
	<div class="col4">
		<input type="text" value="<?php echo $_SERVER["REMOTE_ADDR"]; ?>" readonly>
	</div>
	<div class="col2 col-sr"> </div>
</div>

<div class="row">
	<div class="col3 label">&nbsp</div>
	<div class="col7 text-right">
		<a href="http://eepurl.com/b-6Xan" target="_blank">More Variables</a>
	</div>
	<div class="col3 col-sr"></div>
</div>
