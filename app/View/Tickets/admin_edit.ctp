<div class="tickets form">
<?php echo $this->Form->create('Ticket'); ?>
	<fieldset>
		<legend><?php echo __('Edit ticket'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('short_description');
		echo $this->Form->input('expected_duration');
		echo $this->Form->input('is_support', array('type' => 'checkbox', 'checked'=> $isSupport));
		echo $this->element('colorPicker');
		echo $this->Form->hidden('project_id');
		echo $this->Form->hidden('state_id');
	?>
		<div class="input number">
			<label for="TicketPriority">Priority</label>
				<select id="TicketPriority" name="data[Ticket][priority]">
					<?php
						for($i = 1; $i < 11; $i++) {
					?>
							<option value="<?php echo $i; ?>" <?php echo " ".($priority == $i ? "selected=\"selected\"" : "");?>"><?php echo $i; ?></option>
					<?php		
						}
					?>
				</select>
			</label>
		</div>
		<div class="input number">
			<label for="TicketUserId">User</label>			
			<select id="TicketUserId" name="data[Ticket][user_id]">
				<option value="null">&nbsp;</option>
				<?php
					for($i = 0; $i < count($users); $i++) {
				?>
						<option <?php echo ($this->Form->value('Ticket.user_id') == $users[$i]['User']['id'] ? "selected=\"selected\"" : ""); ?> value="<?php echo $users[$i]['User']['id'] ?>"><?php echo $users[$i]['User']['username'] ?></option>
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
		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Ticket.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('Ticket.id'))); ?></li>
		<li><?php echo $this->Html->link(__('View state'), array('controller' => 'states', 'action' => 'view', $this->Form->value('Ticket.state_id'))); ?></li>
	</ul>
</div>
