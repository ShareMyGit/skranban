<?php
/**
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Pages
 * @since         CakePHP(tm) v 0.10.0.1076
 */

if (!Configure::read('debug')):
	throw new NotFoundException();
endif;

App::uses('Debugger', 'Utility');

function buildTicket($ticket, $ticketUser, $current) {
	return "<div id=\"ticket".$ticket['id']."\"class=\"draggable\" style=\"background-color: ".$ticket['color'].";\">
						<div class=\"ticket_title\">#".$ticket['id']." - ".$ticket['name']."
							<span>".(isset($ticketUser) ? $current->Html->image('controls/man.png', 
											array('alt' => $ticketUser['username'], 
												'border' => 'none', 
												'title' => $ticketUser['username'], 
												'height' => '15', 
												'width' => '15')) : "&nbsp;").
									(!empty($ticket['comment']) ? $current->Html->image('ticket/note.png', 
											array('alt' => $ticket['comment'], 
												'border' => 'none', 
												'title' => $ticket['comment'], 
												'height' => '15', 
												'width' => '15')) : "&nbsp;").
									($current->Html->link($current->Html->image('controls/modify_16.png', 
											array('alt' => 'Edit ticket', 
												'border' => 'none', 
												'title' => 'Edit ticket '.$ticket['name'], 
												'height' => '15', 
												'width' => '15')
												),
											array('controller' => 'tickets',
												'action' => 'edit',
												'admin' => true,
												$ticket['id']
												), 
											array('escape' => false)
											)
										)."
							</span>
							<span class=\"clear\" />
						</div>
						<br />
						<div class=\"ticket_content\">
							<span>Description: ".$ticket['short_description']."</span><br />
							<span>Duration (expected / effective): ".$ticket['expected_duration']." / ".$ticket['effective_duration']." day(s)</span><br /><br />
							<span>Start date: ".$ticket['started']."</span><br />
							<span>
								<div class=\"ticket_footer\">
									End date: ".$ticket['ended']."
									<span>
										[".$ticket['priority']."]
									</span>
									<span class=\"clear\" />
								</div>
							</span>
						</div>
					</div>";
}

	// Check if a project has been selected.
	if(isset($projectSelected)) {
		if(array_key_exists('State', $projectSelected)) {
			$ticketsValues = "";
?>
			<table id="states">
				<tr>
<?php
			$openTicketsTr = false;
			
			// Build the table for each state.
			foreach($projectSelected['State'] as $state) {
?>
				<th class="statesHeader">
					<?php echo $state['name']; ?>					
					<span class="statesHeaderTicketButton">
						<?php echo ($this->Html->link($this->Html->image('controls/add_16.png', 
								array('alt' => 'Add ticket', 
									'border' => 'none', 
									'title' => 'Add ticket', 
									'height' => '15', 
									'width' => '15')
									),
								array('controller' => 'tickets',
									'action' => 'add',
									'admin' => true,
									$state['project_id'],
									$state['id']
									), 
								array('escape' => false)
								)
							); 
						?>
					</span>
					<span class="clear">&nbsp;</span>
				</th>
<?php
				// Display the associated tickets to each state.
				if(isset($projectSelected['Ticket']) && !empty($projectSelected['Ticket'])) {					
					
					if(!$openTicketsTr) {
						$openTicketsTr = true;
						$ticketsValues .= "<tr>";
					}
					$ticketsValues .= "<td id=\"state".$state['id']."\" class=\"droppable connectable\">
											<div class=\"task-wrapper ui-sortable\">&nbsp;</div>
												<div class=\"task-wrapper\">";
					
					// Sort tickets by priority.
					usort($state['Tickets'], function($a, $b) {
					    return $a['priority'] - $b['priority'];
					});
					
					foreach($state['Tickets'] as $ticket) {
						$ticketUser = null;
						if(!empty($ticket['user_id'])) {
							foreach($projectSelected['Users'] as $projectUser) {
								if($projectUser['id'] == $ticket['user_id']) {
									$ticketUser = $projectUser; // Check if an user is associated to the ticket.
									break;
								}
							}
						}
						
						if($ticket['is_support'] == 0) {
							$ticketsValues .= buildTicket($ticket, $ticketUser, $this);
							unset($ticketUser);
						}
					}
					
					$ticketsValues .= "</div>
									</td>";
				}
			}						
?>
				</tr>
<?php
				if(!$openTicketsTr) {
					$ticketsValues .= "</tr>";
				}
				
				echo $ticketsValues;
?>
			</table>
			<table id="unsorted">
				<tr>
					<th class="statesHeader">
						Unsorted tickets
						<span class="statesHeaderTicketButton">
							<?php echo ($this->Html->link($this->Html->image('controls/add_16.png', 
									array('alt' => 'Add ticket', 
										'border' => 'none', 
										'title' => 'Add ticket ', 
										'height' => '15', 
										'width' => '15')
										),
									array('controller' => 'tickets',
										'action' => 'add',
										'admin' => true,
										$state['project_id'],
										-1
										), 
									array('escape' => false)
									)
								);
							?>
						</span>
						<span class="clear">&nbsp;</span>
					</th>
					<th class="statesHeader">
						Prod support
						<span class="statesHeaderTicketButton">				
							<?php echo ($this->Html->link($this->Html->image('controls/add_16.png', 
									array('alt' => 'Add ticket', 
										'border' => 'none', 
										'title' => 'Add ticket ', 
										'height' => '15', 
										'width' => '15')
										),
									array('controller' => 'tickets',
										'action' => 'add',
										'admin' => true,
										$state['project_id'],
										0
										), 
									array('escape' => false)
									)
								);
							?>
						</span>
						<span class="clear">&nbsp;</span>
					</th>
				</tr>
<?php
	echo $this->element('Tickets/home_unsorted_prod_tickets', 
					array('projectSelected' => $projectSelected)
					);
?>
			</table>
<?php
		}
	}
?>
