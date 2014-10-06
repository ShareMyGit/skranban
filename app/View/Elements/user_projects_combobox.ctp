<select id="ProjectUsersProjectId" name="data[Page][project_id]">
	<?php
		for($i = 0; $i < count($projects); $i++) {
	?>
			<option <?php echo isset($projectId) ? ($projectId == $projects[$i]['id'] ? "selected=\"selected\"" : "") : ($lastProjectId == $projects[$i]['id'] ? "selected=\"selected\"" : "") ?> value="<?php echo $projects[$i]['id'] ?>"><?php echo $projects[$i]['name'] ?></option>
	<?php		
		}
	?>
</select>