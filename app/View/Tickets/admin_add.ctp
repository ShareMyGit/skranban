<div class="tickets form">
<?php echo $this->Form->create('Ticket'); ?>
	<fieldset>
		<legend><?php echo __('Create ticket'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('short_description');
		echo $this->Form->input('expected_duration');
		echo $this->Form->input('is_support', array('type' => 'checkbox', 'checked'=> $isSupport));
		echo $this->element('colorPicker');
		echo $this->Form->hidden('project_id', array('value' => $projectId));
		echo $this->Form->hidden('state_id', array('value' => $stateId));
	?>
		<div class="input number">
			<label for="TicketPriority">Priority</label>
				<select id="TicketPriority" name="data[Ticket][priority]">
					<?php
						for($i = 1; $i < 11; $i++) {
					?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
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
						<option value="<?php echo $users[$i]['User']['id'] ?>"><?php echo $users[$i]['User']['username'] ?></option>
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

		<li><?php echo $this->Html->link(__('List Tickets'), array('action' => 'index')); ?></li>
	</ul>
</div>
