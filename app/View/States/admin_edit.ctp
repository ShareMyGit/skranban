<div class="states form">
<?php echo $this->Form->create('State'); ?>
	<fieldset>
		<legend><?php echo __('Edit state'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('max_ticket_nb');
		echo $this->Form->input('is_gate', array('type' => 'checkbox'));
	?>
		<div class="input number">
			<label for="ProjectOwner">Order</label>
			<select id="ProjectUserId" name="data[State][state_order]">
				<?php
					foreach($ordersList as $order) {
				?>
						<option <?php echo ($this->Form->value('State.state_order') == $order['State']['state_order'] ? "selected=\"selected\"" : ""); ?> value="<?php echo $order['State']['state_order']; ?>"><?php echo $order['State']['state_order']; ?></option>
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

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('State.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('State.id'))); ?></li>
		<li><?php echo $this->Html->link(__('New project'), array('controller' => 'projects', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List projects'), array('controller' => 'projects', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Back to '.$state['Project']['name'].' project'), array('controller' => 'projects', 'action' => 'view', $state['Project']['id'])); ?> </li>
	</ul>
</div>
