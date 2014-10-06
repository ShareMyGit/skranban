<div class="tickets view">
<h2><?php echo __('Ticket'); ?></h2>
	<dl>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($ticket['Ticket']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Short Description'); ?></dt>
		<dd>
			<?php echo h($ticket['Ticket']['short_description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Color'); ?></dt>
		<dd>
			<div class="ticket_color" style="background-color: <?php echo h($ticket['Ticket']['color']); ?>;">
				&nbsp;
			</div>
		</dd>
		<dt><?php echo __('State'); ?></dt>
		<dd>
			<?php echo $this->Html->link($ticket['State']['name'], array('controller' => 'states', 'action' => 'view', h($ticket['Ticket']['state_id']))); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Associated user'); ?></dt>
		<dd>
			<?php echo $this->Html->link($ticket['User']['username'], array('controller' => 'users', 'action' => 'view', h($ticket['User']['id']))); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($ticket['Ticket']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($ticket['Ticket']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New account'), array('controller' => 'users', 'action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('List projects'), array('action' => 'index')); ?> </li>
	</ul>
</div>
