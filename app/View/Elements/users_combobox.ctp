<select id="ProjectUsersUserId" name="data[ProjectUsers][user_id]">
	<?php
		foreach($users as $user) {
	?>
			<option value="<?php echo $user['User']['id']?>"><?php echo $user['User']['username']?></option>
	<?php		
		}
	?>
</select>