<?php
	$colors[] = '#ac725e';
	$colors[] = '#d06b64';
	$colors[] = '#f83a22';
	$colors[] = '#fa573c';
	$colors[] = '#ff7537';
	$colors[] = '#ffad46';
	$colors[] = '#42d692';
	$colors[] = '#16a765';
	$colors[] = '#7bd148';
	$colors[] = '#b3dc6c';
	$colors[] = '#fbe983';
	$colors[] = '#fad165';
	$colors[] = '#92e1c0';
	$colors[] = '#9fe1e7';
	$colors[] = '#9fc6e7';
	$colors[] = '#4986e7';
	$colors[] = '#9a9cff';
	$colors[] = '#b99aff';
	$colors[] = '#c2c2c2';
	$colors[] = '#cabdbf';
	$colors[] = '#cca6ac';
	$colors[] = '#f691b2';
	$colors[] = '#cd74e6';
	$colors[] = '#a47ae2';
?>

<div class="input text required">
	<label for="TicketColorId">Color</label>
	<select id="TicketColorId" name="<?php echo $fieldName; ?>">
		<?php
			foreach($colors as $color) {
		?>
			<option value="<?php echo $color; ?>" <?php echo $color == $fieldColor ? "selected=\"selected\"" : ""; ?>><?php echo $color; ?></option>
		<?php	
			}		
		?>
	</select>
</div>