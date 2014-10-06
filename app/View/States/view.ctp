<div class="states view">
<h2><?php echo __('State'); ?></h2>
	<dl>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($state['State']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Project'); ?></dt>
		<dd>
			<?php echo $this->Html->link($state['Project']['name'], array('controller' => 'projects', 'action' => 'view', $state['Project']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
	
	<div class="related">
		<h3><?php echo __('Related tickets'); ?></h3>
		<?php if (!empty($state['Tickets'])): ?>
			<table cellpadding = "0" cellspacing = "0">
			<tr>
				<th><?php echo __('Name'); ?></th>
				<th><?php echo __('Short description'); ?></th>
				<th><?php echo __('Color'); ?></th>
				<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
			<?php foreach ($state['Tickets'] as $ticket): ?>
				<tr>
					<td><?php echo $ticket['name']; ?></td>
					<td><?php echo $ticket['short_description']; ?></td>
					<td>
						<div class="ticket_color" style="background-color: <?php echo h($ticket['color']); ?>;">
							&nbsp;
						</div>
					</td>
					<td class="actions">
						<?php echo $this->Html->link(__('View'), array('controller' => 'tickets', 'action' => 'view', $ticket['id'])); ?>
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
		<li><?php echo $this->Html->link(__('List users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('List projects'), array('controller' => 'projects', 'action' => 'index')); ?> </li>
	</ul>
</div>
