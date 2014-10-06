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
	if(isset($projectSelected)) {
		if(array_key_exists('State', $projectSelected)) {
			$ticketsValues = "";
?>
			<table id="states">
				<tr>
<?php
			$openTicketsTr = false;

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
				if(isset($projectSelected['Ticket']) && !empty($projectSelected['Ticket'])) {					
					
					if(!$openTicketsTr) {
						$openTicketsTr = true;
						$ticketsValues .= "<tr>";
					}
					$ticketsValues .= "<td id=\"state".$state['id']."\" class=\"droppable connectable\">
											<div class=\"task-wrapper ui-sortable\">&nbsp;</div>
												<div class=\"task-wrapper\">";
					
					foreach($state['Tickets'] as $ticket) {	
						if(!empty($ticket['user_id'])) {
							foreach($projectSelected['Users'] as $projectUser) {
								if($projectUser['id'] == $ticket['user_id']) {
									$ticketUser = $projectUser;
									break;
								}
							}
						}
						
						if($ticket['is_support'] == 0) {
							$ticketsValues .= "<div id=\"ticket".$ticket['id']."\"class=\"draggable\" style=\"background-color: ".$ticket['color'].";\">
												<div class=\"ticket_title\">#".$ticket['id']." - ".$ticket['name']."
													<span>".(isset($ticketUser) ? $this->Html->image('controls/man.png', 
																	array('alt' => $ticketUser['username'], 
																		'border' => 'none', 
																		'title' => $ticketUser['username'], 
																		'height' => '15', 
																		'width' => '15')) : "&nbsp;").
															(!empty($ticket['comment']) ? $this->Html->image('ticket/note.png', 
																	array('alt' => $ticket['comment'], 
																		'border' => 'none', 
																		'title' => $ticket['comment'], 
																		'height' => '15', 
																		'width' => '15')) : "&nbsp;").
															($this->Html->link($this->Html->image('controls/modify_16.png', 
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
													<span>End date: ".$ticket['ended']."</span><br />
												</div>
											</div>";
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
			if(!empty($projectSelected['Ticket'])) {
?>
				<tr>
					<td id="state-1" class="droppable connectable">
						<div class=\"task-wrapper ui-sortable\">&nbsp;</div>
						<div class=\"task-wrapper\">
<?php
					foreach($projectSelected['Ticket'] as $unsortedTicket) {
						unset($ticketUser);
						if(($projectSelected['Projects']['id'] == $unsortedTicket['project_id']) && !isset($unsortedTicket['state_id']) && ($unsortedTicket['is_support'] == 0)) {
							if(!empty($unsortedTicket['user_id'])) {
								foreach($projectSelected['Users'] as $projectUser) {
									if($projectUser['id'] == $unsortedTicket['user_id']) {
										$ticketUser = $projectUser;
										break;
									}
								}
							}
							
							echo "<div id=\"ticket".$unsortedTicket['id']."\" class=\"draggable\" style=\"background-color: ".$unsortedTicket['color'].";\">
									<div class=\"ticket_title\">#".$unsortedTicket['id']." - ".$unsortedTicket['name']."
										<span>".(isset($ticketUser) ? $this->Html->image('controls/man.png', 
														array('alt' => $ticketUser['username'], 
															'border' => 'none', 
															'title' => $ticketUser['username'], 
															'height' => '15', 
															'width' => '15')) : "&nbsp;").
												(!empty($unsortedTicket['comment']) ? $this->Html->image('ticket/note.png', 
														array('alt' => $unsortedTicket['comment'], 
															'border' => 'none', 
															'title' => $unsortedTicket['comment'], 
															'height' => '15', 
															'width' => '15')) : "&nbsp;").
												($this->Html->link($this->Html->image('controls/modify_16.png', 
																array('alt' => 'Edit ticket', 
																	'border' => 'none', 
																	'title' => 'Edit ticket '.$unsortedTicket['name'], 
																	'height' => '15', 
																	'width' => '15')
																	),
																array('controller' => 'tickets',
																	'action' => 'edit',
																	'admin' => true,
																	$unsortedTicket['id']
																	), 
																array('escape' => false)
																)
															)."
										</span>
										<span class=\"clear\" />
									</div>
									<br />
									<div class=\"ticket_content\">
										<span>Description: ".$unsortedTicket['short_description']."</span><br />
										<span>Duration (expected / effective): ".$unsortedTicket['expected_duration']." / ".$unsortedTicket['effective_duration']." day(s)</span><br /><br />
										<span>Start date: ".$unsortedTicket['started']."</span><br />
										<span>End date: ".$unsortedTicket['ended']."</span><br />
									</div>
								</div>";
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
						unset($ticketUser);
						if(($projectSelected['Projects']['id'] == $unsortedTicket['project_id']) && !isset($unsortedTicket['state_id']) && ($unsortedTicket['is_support'] == 1)) {
							if(!empty($unsortedTicket['user_id'])) {
								foreach($projectSelected['Users'] as $projectUser) {
									if($projectUser['id'] == $unsortedTicket['user_id']) {
										$ticketUser = $projectUser;
										break;
									}
								}
							}
							
							echo "<div id=\"ticket".$unsortedTicket['id']."\" class=\"draggable\" style=\"background-color: ".$unsortedTicket['color'].";\">
									<div class=\"ticket_title\">#".$unsortedTicket['id']." - ".$unsortedTicket['name']."
										<span>".(isset($ticketUser) ? $this->Html->image('controls/man.png', 
														array('alt' => $ticketUser['username'], 
															'border' => 'none', 
															'title' => $ticketUser['username'], 
															'height' => '15', 
															'width' => '15')) : "&nbsp;").
												(!empty($unsortedTicket['comment']) ? $this->Html->image('ticket/note.png', 
														array('alt' => $unsortedTicket['comment'], 
															'border' => 'none', 
															'title' => $unsortedTicket['comment'], 
															'height' => '15', 
															'width' => '15')) : "&nbsp;").
												($this->Html->link($this->Html->image('controls/modify_16.png', 
														array('alt' => 'Edit ticket', 
															'border' => 'none', 
															'title' => 'Edit ticket '.$unsortedTicket['name'], 
															'height' => '15', 
															'width' => '15')
															),
														array('controller' => 'tickets',
															'action' => 'edit',
															'admin' => true,
															$unsortedTicket['id']
															), 
														array('escape' => false)
														)
													)."
										</span>
										<span class=\"clear\" />
									</div>
									<br />
									<div class=\"ticket_content\">
										<span>Description: ".$unsortedTicket['short_description']."</span><br />
										<span>Duration (expected / effective): ".$unsortedTicket['expected_duration']." / ".$unsortedTicket['effective_duration']." day(s)</span><br /><br />
										<span>Start date: ".$unsortedTicket['started']."</span><br />
										<span>End date: ".$unsortedTicket['ended']."</span><br />
									</div>
								</div>";
						}
					}
?>
						</div>
					</td>
				</tr>
<?php
			}
?>
			</table>
<?php
		}
	}
?>
