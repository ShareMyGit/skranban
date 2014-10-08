<?php
	if(!empty($projectSelected['Ticket'])) {
?>
		<tr>
			<td id="state-1" class="droppable connectable">
				<div class=\"task-wrapper ui-sortable\">&nbsp;</div>
				<div class=\"task-wrapper\">
	<?php
			foreach($projectSelected['Ticket'] as $unsortedTicket) {
				$ticketUser = null;
				if(($projectSelected['Projects']['id'] == $unsortedTicket['project_id']) && !isset($unsortedTicket['state_id']) && ($unsortedTicket['is_support'] == 0)) {
					if(!empty($unsortedTicket['user_id'])) {
						foreach($projectSelected['Users'] as $projectUser) {
							if($projectUser['id'] == $unsortedTicket['user_id']) {
								$ticketUser = $projectUser;
								break;
							}
						}
					}
				
					echo buildTicket($unsortedTicket, $ticketUser, $this);
				}
			}
	?>
				</div>
			</td>
			<td id="state0" class="droppable connectable">
				<div class=\"task-wrapper ui-sortable\">&nbsp;</div>
				<div class=\"task-wrapper\">
	<?php
			foreach($projectSelected['Ticket'] as $unsortedTicket) {
				$ticketUser = null;
				if(($projectSelected['Projects']['id'] == $unsortedTicket['project_id']) && !isset($unsortedTicket['state_id']) && ($unsortedTicket['is_support'] == 1)) {
					if(!empty($unsortedTicket['user_id'])) {
						foreach($projectSelected['Users'] as $projectUser) {
							if($projectUser['id'] == $unsortedTicket['user_id']) {
								$ticketUser = $projectUser;
								break;
							}
						}
					}
				
					echo buildTicket($unsortedTicket, $ticketUser, $this);
				}
			}
	?>
				</div>
			</td>
		</tr>
<?php
	}
?>