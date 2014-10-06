<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Create account'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('lastname');
		echo $this->Form->input('username');
		echo $this->Form->input('email');
		echo $this->Form->input('password');
		echo $this->Form->input('passwordConfirmation');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List users'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List projects'), array('controller' => 'projects', 'action' => 'index')); ?> </li>
	</ul>
</div>
