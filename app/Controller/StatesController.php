<?php
App::uses('AppController', 'Controller');
/**
 * States Controller
 *
 */
class StatesController extends AppController {

	public $helpers = array('Session');
	
	public $components = array('Paginator'/*, 'DebugKit.Toolbar'*/);
	public $paginate = array('limit' => 25);
	
/**
 * Scaffold
 *
 * @var mixed
 */
	public $scaffold;

	/**
	 * Display the list of states.
	 */
	public function admin_index($projectId = null) {
		if($projectId) {
			$this->State->settings = $this->paginate;
			$this->set('states', $this->Paginator->paginate('State'));
		}else{
			$this->Session->setFlash(__('Undefined states.'));
		}
	}
	
	/**
	 * Add a new state.
	 */
	public function admin_add($projectId = null) {
		if($this->request->is('post')) {
			$this->State->create();
			
			if ($this->State->save($this->request->data)) {
		    	$this->Session->setFlash(__('The state has been created.'));
				return $this->redirect(array('controller' => 'projects', 'action' => 'view', 'admin' => true, $this->request->data['State']['project_id']));
		    }
		
			$this->Session->setFlash(__('Unable to create your state.'));	
		}
		
		if($projectId) {
			$this->set('projectId', $projectId);
			
			$maxOrder = $this->max_order($projectId);
			
			// Set the order of the new state to the max found for this project and add 1.
			$this->set('order', (isset($maxOrder) && !empty($maxOrder)) ? $maxOrder + 1 : 1);
		}else{
			$this->Session->setFlash(__('A state must be associated to a project.'));
		}
	}
	
	/**
	 * View a state data.
	 */
	public function view($id = null) {
		if(!$id) {
			throw new NotFoundException(__('Invalid state'));
		 }

		 $state = $this->State->findById($id);
		
		 if (!$state) {
		 	throw new NotFoundException(__('Invalid state'));
		 }
		
		 $this->set('state', $state);
	}
	
	/**
	 * View a state data.
	 */
	public function admin_view($id = null) {
		$this->view($id);
	}
	
	/**
	 * Edit a state.
	 */
	public function admin_edit($id = null) {
		if(!$id) {
			throw new NotFoundException(__('Invalid state'));
		}

		$state = $this->State->findById($id);
		
		if (!$state) {
	 		throw new NotFoundException(__('Invalid state'));
		}
		
		/**
		 * Get all states order by their order number.
		 */
		$this->set('ordersList', $this->State->find('all', 
													array(
														'recursive' => -1,
														'fields' => array('State.state_order'),
														'conditions' => array('project_id' => $state['Project']['id']),
														'order' => 'State.state_order ASC'
														)
													)
												);
		
		if($state['Project']['user_id'] == AuthComponent::user('id')) {
				
		    if($this->request->is(array('post', 'put'))) {
					if($this->request->data['State']['state_order'] > 0)  {
		        		$this->State->id = $id;
						
						if($this->shiftOrders($state['Project']['id'], $state['State']['id'], $this->request->data['State']['state_order'], $state['State']['state_order'])) {
				        	if($this->State->save($this->request->data)) {
					            $this->Session->setFlash(__('The state has been updated.'));
					            return $this->redirect(array('controller' => 'projects', 'action' => 'view', $state['Project']['id']));
					    	}
							$this->Session->setFlash(__('Unable to update the state.'));
 						}else{
							$this->Session->setFlash(__('Unable to update the states orders.'));
						}
					}else{
						$this->Session->setFlash(__('Invalid order.'));
					}
		    }
		}else{
			$this->Session->setFlash(__('Your are not allowed to edit this state.'));
			return $this->redirect(array('controller' => 'projects', 'action' => 'view', $state['Project']['id']));
		}
		
		$this->set('state', $state);
		$this->request->data = $state;
	}
	
	/**
	 * Shift the states' order.
	 */
	public function shiftOrders($project_id, $state_id, $new_order, $old_order) {
		$states = $this->State->find('all', 
										array(
											'recursive' => -1,
											'conditions' => array('project_id' => $project_id),
											'order' => 'State.state_order ASC'
											)
										);
		$saveOk = true;
		
		if($states) {
			foreach($states as $state) {
				if($state['State']['id'] != $state_id) {
					if($new_order < $old_order) {
						if(($state['State']['state_order'] >= $new_order) && ($state['State']['state_order'] < $old_order)) {
							$state['State']['state_order'] = $state['State']['state_order'] + 1;
							$this->State->create();
							if(!$this->State->save($state)) {
								return false;
							}
						}
					}else{
						if($new_order > $old_order) {
							if($state['State']['state_order'] <= $new_order) {
								$state['State']['state_order'] = $state['State']['state_order'] - 1;
								$this->State->create();
								if(!$this->State->save($state)) {
									return false;
								}
							}
						}
					}
				}
			}
		}
		
		return $saveOk;
	}
	
	/**
	 * Find the max state order of the project.
	 */
	public function max_order($projectId) {
		$maxOrder = $this->State->find('first', array(
									'fields' => array('MAX(State.state_order) AS state_order'),
		    						'conditions' => array('project_id' => $projectId),
									'recursive' => 0
								)
							);
							
		return (isset($maxOrder) && !empty($maxOrder)) ? $maxOrder[0]['state_order'] : 0;
	}
	
	/**
	 * Delete a state.
	 */
	public function admin_delete($id = null) {
		$this->State->id = $id;
		
		if (!$this->State->exists()) {
            $this->Session->setFlash(__('Invalid state.'));
			return $this->redirect(array('action' => 'index'));
        }
		
		$state = $this->State->findById($id);
		if($state['Project']['user_id'] != AuthComponent::user('id')) {
			$this->Session->setFlash(__('You are not authorized to delete this state.'));
			return $this->redirect(array('controller' => 'projects', 'action' => 'index'));
		}
		
		// Set the state id of all associated tickets => unsorted tickets.
		if($state['Tickets']) {
			foreach($state['Tickets'] as $ticket) {
				$this->State->create();
				$ticket['state_id'] = null;
				$this->State->Tickets->save($ticket);
			}
		}
		
		if($this->State->delete($id, false)) {
			$maxOrder = $this->max_order($state['Project']['id']);
			if($this->shiftOrders($state['Project']['id'], $state['State']['id'], $maxOrder, $state['State']['state_order'])) {
				$this->Session->setFlash(__('The state has been deleted.'));
				return $this->redirect(array('controller' => 'projects', 'action' => 'view', $state['State']['project_id']));
			}else{
				$this->Session->setFlash(__('Unable to update the states orders.'));
			}
		}else{
			$this->Session->setFlash(__('Unable to delete the state.'));
		}
	}
}
