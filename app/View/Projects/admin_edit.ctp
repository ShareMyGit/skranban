<div class="projects form">
<?php echo $this->Form->create('Project'); ?>
	<fieldset>
		<legend><?php echo __('Edit Project'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('max_ticket_nb_user');
	?>
		<div class="input number">
			<label for="ProjectOwner">Owner</label>
			<select id="ProjectUserId" name="data[Project][user_id]">
				<?php
					for($i = 0; $i < count($users); $i++) {
				?>
						<option <?php echo ($user_id == $users[$i]['User']['id'] ? "selected=\"selected\"" : ""); ?> value="<?php echo $users[$i]['User']['id'] ?>"><?php echo $users[$i]['User']['username'] ?></option>
				<?php		
					}
				?>
			</select>
		</div>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Project.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('Project.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List all projects'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('New State'), array('controller' => 'states', 'action' => 'add', $this->Form->value('Project.id'))); ?> </li>
		<li><?php echo $this->Html->link(__('List Project Users'), array('controller' => 'project_users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Project Users'), array('controller' => 'project_users', 'action' => 'add')); ?> </li>
	</ul>
</div>
