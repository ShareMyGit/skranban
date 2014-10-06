<div class="users view">
<h2><?php echo (AuthComponent::user('id') && (AuthComponent::user('id') == $user['User']['id'])) ? __('My account') : __('User'); ?></h2>
	<dl>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($user['User']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lastname'); ?></dt>
		<dd>
			<?php echo h($user['User']['lastname']); ?>
			&nbsp;
		</dd>
			<dt><?php echo __('Username'); ?></dt>
			<dd>
				<?php echo h($user['User']['username']); ?>
				&nbsp;
			</dd>
		<dt><?php echo __('Email'); ?></dt>
		<dd>
			<?php echo h($user['User']['email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($user['User']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($user['User']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
	<div class="related">
		<h3><?php echo __('Related projects'); ?></h3>
		<?php if (!empty($user['Projects'])): ?>
		<table cellpadding = "0" cellspacing = "0">
		<tr>
			<th><?php echo __('Name'); ?></th>
			<th><?php echo __('Owner'); ?></th>
			<th><?php echo __('Created'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
		</tr>
		<?php foreach ($user['Projects'] as $projectUsers): ?>
			<tr>
				<td><?php echo $projectUsers['name']; ?></td>
				<td><?php echo ((AuthComponent::user('id') && (AuthComponent::user('id') == $projectUsers['user_id'])) ? "Yes" : "No"); ?></td>
				<td><?php echo $projectUsers['created']; ?></td>
				<td class="actions">
					<?php 
						echo $this->Html->link(__('View'), array('controller' => 'projects', 'action' => 'view', 'admin' => true, $projectUsers['id']));

						if(AuthComponent::user('id') && (AuthComponent::user('id') == $projectUsers['user_id'])) {
							echo $this->Html->link(__('Edit'), array('controller' => 'projects', 'action' => 'edit', 'admin' => true, $projectUsers['id']));
							echo $this->Form->postLink(__('Delete'), array('controller' => 'projects', 'action' => 'delete', 'admin' => true, $projectUsers['id']), array(), __('Are you sure you want to delete # %s?', $projectUsers['id']));
						}
					?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
	<?php endif; ?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<?php
			if(AuthComponent::user('id') && (AuthComponent::user('id') == $user['User']['id'])) {
		?>
				<li><?php echo $this->Html->link(__('Edit my account'), array('action' => 'edit', 'admin' => true, $user['User']['id'])); ?> </li>
				<li><?php echo $this->Form->postLink(__('Delete my account'), array('action' => 'delete', 'admin' => true, $user['User']['id']), array(), __('Are you sure you want to delete your account?')); ?> </li>
		<?php
			}
		?>
		<li><?php echo $this->Html->link(__('List users'), array('action' => 'index', 'admin' => true)); ?> </li>
		<li><?php echo $this->Html->link(__('New project'), array('controller' => 'projects', 'action' => 'add', 'admin' => true)); ?> </li>
		<li><?php echo $this->Html->link(__('List all projects'), array('controller' => 'projects', 'action' => 'index', 'admin' => true)); ?> </li>		
	</ul>
</div>
