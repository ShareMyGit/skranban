<?php
App::uses('AppController', 'Controller');
App::uses('Security', 'Utility');

/**
 * Tickets Controller
 *
 */
class TicketsController extends AppController {

	public $components = array('Paginator', 'RequestHandler'/*, 'DebugKit.Toolbar'*/);
	public $paginate = array('limit' => 25);
	
/**
 * Scaffold
 *
 * @var mixed
 */
	public $scaffold;

	public function admin_index($projectId = null) {
		if($projectId) {
			$this->Ticket->settings = $this->paginate;
			$this->set('tickets', $this->Paginator->paginate('Ticket'));
		}else{
			$this->Session->setFlash(__('Undefined ticket.'));
		}
	}
	
	/**
	 * Add a new ticket.
	 */
	public function admin_add($projectId = null, $stateId = null) {
		if($this->request->is('post')) {
			$this->Ticket->create();
			
			if(!isset($this->request->data['Ticket']['expected_duration']) || empty($this->request->data['Ticket']['expected_duration']) || !is_numeric($this->request->data['Ticket']['expected_duration'])) {
				$this->request->data['Ticket']['expected_duration'] = 0;
			}
			
			if(!isset($this->request->data['Ticket']['is_support']) || !is_numeric($this->request->data['Ticket']['is_support'])) {
				$this->request->data['Ticket']['is_support'] = null;
			}
			
			if ($this->Ticket->save($this->request->data)) {
		    	$this->Session->setFlash(__('Your ticket has been created.'));
				return $this->redirect(array('action' => 'index', 'admin' => true, $this->request->data['Ticket']['project_id']));
		    }
	    
			$this->Session->setFlash(__('Unable to create your ticket.'));
		}
		
		if(isset($projectId) && is_numeric($projectId)) {
			$this->set('projectId', $projectId);
		}else{
			$this->Session->setFlash(__('Unknown project.'));
			return $this->redirect($this->referer());
		}
		
		$this->set('isSupport', false);
		$this->set('stateId', null);
		
		if(isset($stateId) && is_numeric($stateId)) {
			if($stateId != -1) { // Not unsorted ticket.
				if($stateId == 0) { // Prod support.
					$this->set('isSupport', true);
				}else{
					$this->set('stateId', $stateId);
				}
			}
		}
		
		$this->set('fieldName', 'data[Ticket][color]');
		$this->set('fieldColor', null);
		
		$this->loadModel('ProjectUsers');
		$users = $this->ProjectUsers->find('all', array(
		    						'conditions' => array('project_id' => $projectId)
									)
								);
		$this->set('users', $users);
	}
	
	public function view($id = null) {
		if(!$id) {
			throw new NotFoundException(__('Invalid ticket.'));
		 }

		 $ticket = $this->Ticket->findById($id);
		 if (!$ticket) {
		 	throw new NotFoundException(__('Invalid ticket.'));
		 }
		
		 $this->set('ticket', $ticket);
	}
	
	public function admin_isGateLimitExceeded($state_id = null) {
		$this->autoRender = false;
		$this->request->onlyAllow('ajax');
		
		$response = false;
		
		if(($state_id == null) && ($state_id != 0) && !is_numeric($state_id)) {
			$response = 'Invalid state.';
		}
		
		if($this->request->is(array('post', 'put'))) {
			$count = $this->Ticket->find('count', array(
		            		'conditions' => array('state_id' => $state_id),
			            	'recursive' => -1
		        		)
					);
			
			$this->loadModel('State');
			$state = $this->State->find('first',
										array('conditions' => array('id' => $state_id),
											'fields' => array('State.max_ticket_nb', 'State.name'),
											'recursive' => -1
											)
										);
			
			$response = 'Invalid state.';
			
			if($count) {
				if($count < $state['State']['max_ticket_nb']) {
					$response = true;
				}else{
					$response = 'Max tickets number exceeded for state '.$state['State']['name'].".";
				}
			}
		}
		
		return json_encode($response);
	}
	
	public function admin_edit($id = null) {
		if(!$id) {
			throw new NotFoundException(__('Invalid ticket.'));
		}

		$ticket = $this->Ticket->findById($id);
		
		if (!$ticket) {
	 		throw new NotFoundException(__('Invalid ticket.'));
		}
		
		if($this->request->is(array('post', 'put'))) {
			$this->Ticket->id = $id;
			$this->request->data['Ticket']['id'] = $id;
			
			$this->Ticket->create();
			
			if(!isset($this->request->data['Ticket']['expected_duration']) || empty($this->request->data['Ticket']['expected_duration']) || !is_numeric($this->request->data['Ticket']['expected_duration'])) {
				$this->request->data['Ticket']['expected_duration'] = 0;
			}
			
			if(!isset($this->request->data['Ticket']['is_support']) || !is_numeric($this->request->data['Ticket']['is_support'])) {
				$this->request->data['Ticket']['is_support'] = null;
			}
			
			if ($this->Ticket->save($this->request->data)) {
		    	$this->Session->setFlash(__('Your ticket has been updated.'));
		    }else{
				$this->Session->setFlash(__('Unable to update your ticket.'));
			}
		}
		
		$this->set('isSupport', $ticket['Ticket']['is_support'] == 1);
		
		$this->set('fieldName', 'data[Ticket][color]');		
		$this->set('fieldColor', $ticket['Ticket']['color']);
		$this->set('priority', $ticket['Ticket']['priority']);
		$this->request->data = $ticket;
		
		$this->loadModel('ProjectUsers');
		$users = $this->ProjectUsers->find('all', array(
		    						'conditions' => array('project_id' => $ticket['Ticket']['project_id'])
									)
								);
		$this->set('users', $users);
	}
	
	public function admin_ajaxEdit($id = null, $state_id = null) {
		if(!$id) {
			$this->Session->setFlash(__('Invalid ticket.'));
		}
		
		if(($state_id == null) && ($state_id != 0) && !is_numeric($state_id)) {
			$this->Session->setFlash(__('Invalid state.'));
		}

		$ticket = $this->Ticket->findById($id);
		
		if (!$ticket) {
	 		$this->Session->setFlash(__('Invalid ticket.'));
		}
		
		if($this->request->is(array('post', 'put'))) {
			$this->Ticket->id = $id;
			$this->request->data = $ticket;
			$this->request->data['Ticket']['id'] = $id;
			
			if($state_id == -1) { // Unsorted ticket.
				$this->request->data['Ticket']['state_id'] = null;
			}else{
				if($state_id == 0) { // Prod support ticket.
					$this->request->data['Ticket']['state_id'] = null;
					$this->request->data['Ticket']['is_support'] = 1;
				}else{
					$this->request->data['Ticket']['state_id'] = $state_id;
				}
			}
			
			$this->Ticket->create();
			
			if(!isset($this->request->data['Ticket']['expected_duration']) || empty($this->request->data['Ticket']['expected_duration']) || !is_numeric($this->request->data['Ticket']['expected_duration'])) {
				$this->request->data['Ticket']['expected_duration'] = 0;
			}
			
			if(!isset($this->request->data['Ticket']['is_support']) || !is_numeric($this->request->data['Ticket']['is_support'])) {
				$this->request->data['Ticket']['is_support'] = null;
			}
			
			if ($this->Ticket->save($this->request->data)) {
		    	$this->Session->setFlash(__('Your ticket has been updated.'));
		    }else{
				$this->Session->setFlash(__('Unable to update your ticket.'));
			}
		}
	}
	
	public function admin_delete($id = null) {
		$this->Ticket->id = $id;
		
		if (!$this->Ticket->exists()) {
            $this->Session->setFlash(__('Invalid ticket.'));
			return $this->redirect(array('controller' => 'pages', 'action' => '/', 'admin' => false));
        }
		
		$ticket = $this->Ticket->findById($id);
		
		if($ticket['Project']['user_id'] != AuthComponent::user('id')) {
			$this->Session->setFlash(__('You are not authorized to delete this state.'));
			return $this->redirect(array('controller' => 'pages', 'action' => '/', 'admin' => false));
		}
		
		if($this->Ticket->delete($id, false)) {
			$this->Session->setFlash(__('The ticket has been deleted.'));
		}else{
			$this->Session->setFlash(__('Unable to delete the ticket.'));
		}
		
		return $this->redirect(array('controller' => 'pages', 'action' => '/', 'admin' => false));
	}
	
	public function isAuthorized() {
		return true;
	}
}
