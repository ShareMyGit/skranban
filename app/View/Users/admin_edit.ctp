<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Edit my account'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('lastname');
		echo $this->Form->input('username');
		echo $this->Form->input('email');
		echo $this->Form->input('newPassword');
		echo $this->Form->input('newPasswordConfirmation');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Form->postLink(__('Delete my account'), array('action' => 'delete', $this->Form->value('User.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('User.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List users'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('New project'), array('controller' => 'projects', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List all projects'), array('controller' => 'projects', 'action' => 'index')); ?> </li>
	</ul>
</div>
