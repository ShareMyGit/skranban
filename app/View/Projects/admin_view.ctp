<div class="projects view">
<h2><?php echo __('Project'); ?></h2>
	<dl>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($project['Project']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($project['Project']['created']); ?>
			&nbsp;
		</dd>
	</dl>
	<div class="related">
		<h3><?php echo __('Related states'); ?></h3>
		<?php if (!empty($project['State'])): ?>
		<table cellpadding = "0" cellspacing = "0">
		<tr>
			<th><?php echo __('Order'); ?></th>
			<th><?php echo __('Name'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
		</tr>
		<?php foreach ($project['State'] as $state): ?>
			<tr>
				<td><?php echo $state['state_order']; ?></td>
				<td><?php echo $state['name']; ?></td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('controller' => 'states', 'action' => 'view', $state['id'])); ?>
					<?php 
						if(AuthComponent::user('id') && (AuthComponent::user('id') == $project['Project']['user_id'])) {
							echo $this->Html->link(__('Edit'), array('controller' => 'states', 'action' => 'edit', $state['id']));
							echo $this->Html->link(__('Delete'), array('controller' => 'states', 'action' => 'delete', $state['id']), array(), __('Are you sure you want to delete # %s?', $state['name']));
						}
					?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
	<?php endif; ?>

		<div class="actions">
			<ul>
				<li><?php echo $this->Html->link(__('New State'), array('controller' => 'states', 'action' => 'add', h($project['Project']['id']))); ?> </li>
			</ul>
		</div>
	</div>
	
	<div class="related">
		<h3><?php echo __('Related project users'); ?></h3>
		<?php if (!empty($project['Users'])): ?>
		<table cellpadding = "0" cellspacing = "0">
		<tr>
			<th><?php echo __('Username'); ?></th>
			<th><?php echo __('Owner'); ?></th>
			<th><?php echo __('Created'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
		</tr>
		<?php foreach ($project['Users'] as $projectUsers): ?>
			<tr>
				<td><?php echo $projectUsers['username']; ?></td>
				<td><?php echo ($project['Project']['user_id'] == $projectUsers['id']) ? "Yes" : "No"; ?></td>
				<td><?php echo $projectUsers['created']; ?></td>
				<td class="actions">
					<?php 
						echo $this->Html->link(__('View'), array('controller' => 'users', 'action' => 'view', $projectUsers['id']));
						
						if(AuthComponent::user('id')) {
							if(AuthComponent::user('id') == $projectUsers['id']) {
					 			echo $this->Html->link(__('Edit'), array('controller' => 'users', 'action' => 'edit', $projectUsers['id']));
							}else{
								if(AuthComponent::user('id') == $project['Project']['user_id']) {
									echo $this->Html->link(__('Remove'), array('controller' => 'projects', 'action' => 'remove', $project['Project']['id'], $projectUsers['id'], $projectUsers['ProjectUser']['id']), array(), __('Are you sure you want to remove # %s?', $projectUsers['username']));
								}
							}
						}
					?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
	<?php endif; ?>

		<div class="actions">
			<?php
				if(AuthComponent::user('id') && (AuthComponent::user('id') == $project['Project']['user_id'])) {
					echo $this->Form->create('ProjectUsers');
					echo $this->Form->hidden('project_id', array('value' => h($project['Project']['id'])));
					echo $this->element('users_combobox');
					echo $this->Form->end('Add user');
				}
			?>
		</div>
	</div>
</div>

<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New project'), array('action' => 'add')); ?> </li>
		<?php
			if(AuthComponent::user('id') && (AuthComponent::user('id') == $project['Project']['user_id'])) {
		?>
				<li><?php echo $this->Html->link(__('Edit project'), array('action' => 'edit', $project['Project']['id'])); ?> </li>
				<li><?php echo $this->Form->postLink(__('Delete project'), array('action' => 'delete', $project['Project']['id']), array(), __('Are you sure you want to delete this project?')); ?> </li>
		<?php
			}
		?>
		<li><?php echo $this->Html->link(__('List all projects'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New ticket'), array('controller' => 'tickets', 'action' => 'add', $project['Project']['id'])); ?> </li>	
		<li><?php echo $this->Html->link(__('List tickets'), array('controller' => 'tickets', 'action' => 'index', $project['Project']['id'])); ?> </li>		
	</ul>
</div>
