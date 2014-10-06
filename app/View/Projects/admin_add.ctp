<div class="projects form">
<?php echo $this->Form->create('Project'); ?>
	<fieldset>
		<legend><?php echo __('Create project'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('max_ticket_nb_user', array('value' => 8));
		echo $this->Form->hidden('user_id', array('value' => AuthComponent::user('id')));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List users'), array('controller' => 'users', 'action' => 'index', 'admin' => true)); ?> </li>
		<li><?php echo $this->Html->link(__('List projects'), array('controller' => 'projects', 'action' => 'index', 'admin' => true)); ?> </li>
	</ul>
</div>
