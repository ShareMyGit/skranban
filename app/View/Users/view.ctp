<div class="users view">
<h2><?php echo __('User'); ?></h2>
	<dl>
		<dt><?php echo __('User name'); ?></dt>
		<dd>
			<?php echo h($user['User']['username']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($user['User']['created']); ?>
			&nbsp;
		</dd>
	</dl>
	<div class="related">
		<h3><?php echo __('Related projects'); ?></h3>
		<?php if (!empty($user['Projects'])): ?>
		<table cellpadding = "0" cellspacing = "0">
		<tr>
			<th><?php echo __('Name'); ?></th>
			<th><?php echo __('Created'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
		</tr>
		<?php foreach ($user['Projects'] as $projectUsers): ?>
			<tr>
				<td><?php echo $projectUsers['name']; ?></td>
				<td><?php echo $projectUsers['created']; ?></td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('controller' => 'projects', 'action' => 'view', $projectUsers['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New account'), array('controller' => 'users', 'action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List users'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List projects'), array('controller' => 'projects', 'action' => 'index')); ?> </li>
	</ul>
</div>
