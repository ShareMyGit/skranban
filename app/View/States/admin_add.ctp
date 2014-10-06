<div class="states form">
<?php echo $this->Form->create('State'); ?>
	<fieldset>
		<legend><?php echo __('Create State'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('max_ticket_nb', array('value' => 8));
		echo $this->Form->hidden('project_id', array('value' => $projectId));
		echo $this->Form->hidden('state_order', array('value' => $order));
	?>			
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List States'), array('action' => 'index', $projectId)); ?></li>
		<li><?php echo $this->Html->link(__('List Projects'), array('controller' => 'projects', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Project'), array('controller' => 'projects', 'action' => 'add')); ?> </li>
	</ul>
</div>
