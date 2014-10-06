<?php
App::uses('AppController', 'Controller');
/**
 * Projects Controller
 *
 */
class ProjectsController extends AppController {
	
	public $helpers = array('Session');

	public $components = array('Paginator'/*, 'DebugKit.Toolbar'*/);
	public $paginate = array('limit' => 25);

/**
 * Scaffold
 *
 * @var mixed
 */
	public $scaffold;

	public function index() {
		$this->Paginator->settings = $this->paginate;
		$this->set('projects', $this->Paginator->paginate('Project'));
	}
	
	public function admin_index($id = null) {
		if($id) {
			$this->Project->bindModel(array(
			    'belongsTo' => array(
			        'ProjectUsers' => array(
			            'foreignKey' => false,
			            'conditions' => array('Project.id = ProjectUsers.project_id')
			        )
			    )
			));
			
			$this->Paginator->settings = array(
			        		'conditions' => array('ProjectUsers.user_id' => $id), 
							'contain' => array('ProjectUsers')
						);
		}else{
			$this->Paginator->settings = $this->paginate;
		}
		
		$this->set('projects', $this->Paginator->paginate('Project'));
	}
	
	public function admin_edit($id) {
		if(!$id) {
		   $this->Session->setFlash(__('Invalid project.'));
			return $this->redirect(array('action' => 'index'));
	    }

	    $project = $this->Project->findById($id);
	
	    if(!$project) {
	        $this->Session->setFlash(__('No project found.'));
			return $this->redirect(array('action' => 'index'));
	    }else{
			if($project['Project']['user_id'] == AuthComponent::user('id')) {
		    	if($this->request->is(array('post', 'put'))) {

			        	$this->Project->id = $id;
				        if($this->Project->save($this->request->data)) {
				            $this->Session->setFlash(__('The project has been updated.'));
				            return $this->redirect(array('action' => 'index', AuthComponent::user('id')));
				    	}
						$this->Session->setFlash(__('Unable to update the project.'));
			    }else{
					if(!$this->request->data) {
				        $this->request->data = $project;
				
						$this->loadModel('ProjectUsers');
						$users = $this->ProjectUsers->find('all', array(
						    						'conditions' => array('project_id' => $id)
													)
												);
						$this->set('users', $users);
						$this->set('user_id', $project['Project']['user_id']);
				    }
				}
			}else{
				$this->Session->setFlash(__('Your are not allowed to edit this project.'));
			}
		}		
	}
	
	public function view($id = null) {
		if(!$id) {
		   throw new NotFoundException(__('Invalid project'));
	    }

	    $project = $this->Project->findById($id);

	    if(!$project) {
	        throw new NotFoundException(__('Invalid project'));
	    }
	
		$this->set('project', $project);
		
		if($this->request->is('post')) {
			$this->loadModel('ProjectUsers');
			$this->ProjectUsers->create();
			
			if($this->ProjectUsers->save($this->request->data)) {
				// Set default project if none is defined.
				$this->loadModel('User');

				$user = $this->User->read(null, $this->request->data['ProjectUsers']['user_id']);
			
				if(!isset($user['User']['default_project'])) {
					$user['User']['default_project'] = $this->request->data['ProjectUsers']['project_id'];
					$this->User->save($user, false);
				}
				
		    	$this->Session->setFlash(__('The user has been added.'));
				return $this->redirect($this->referer());
		    }
	    
			$this->Session->setFlash(__('Unable to add this user to the project.'));
		}
	
		$projectUsers = $project['Users'];
		
		$projectUsersId = array();
		for($i = 0; $i < count($projectUsers); $i++) {
			$projectUsersId[$i] = $projectUsers[$i]['id'];
		}
		
		$this->loadModel('User');
		$users = $this->User->find('all', array(
		    						'conditions' => array(
								        "NOT" => array( 'User.id' => $projectUsersId)
									)
								)
							);
		$this->set('users', $users);
		$this->set('isRelated', $this->isRelated($projectUsers));
	}
	
	public function admin_view($id = null) {
		$this->view($id);
	}
	
	public function isRelated($projectUsers) {
		for($i = 0; $i < count($projectUsers); $i++) {
			if($projectUsers[$i]['id'] == AuthComponent::user('id')) {
				return true;
			}
		}
		
		return false;
	}
	
	public function admin_add() {
		if($this->request->is('post')) {
			$this->Project->create();
			
			if ($this->Project->save($this->request->data)) {
				$projectId = $this->Project->id;
				$userId = $this->request->data['Project']['user_id'];
				
		    	$this->Session->setFlash(__('The project has been created.'));
		
				$this->loadModel('ProjectUsers');
				$this->ProjectUsers->create();

				$this->request->data['ProjectUsers']['project_id'] = $projectId;
				$this->request->data['ProjectUsers']['user_id'] = $userId;
				
				if($this->ProjectUsers->save($this->request->data)) {
			    	$this->Session->setFlash(__('The project has been created.'));
			
					// Set default project if none is defined.
					$this->loadModel('User');

					$user = $this->User->read(null, $userId);
					if(!isset($user['User']['default_project'])) {
						unset($user['User']['password']);
						$this->User->save($user);
					}
			
					return $this->redirect(array('action' => 'index', 'admin' => true));
			    }
		
				return $this->redirect(array('action' => 'index', 'admin' => true));
		    }
	    
			$this->Session->setFlash(__('Unable to create the project.'));
		}
	}
	
	public function admin_remove($project_id = null, $userId = null, $projectUsers_id = null) {
		if(!$project_id) {
		   throw new NotFoundException(__('Invalid project.'));
	    }
	
		if(!$userId) {
		   throw new NotFoundException(__('Invalid user.'));
	    }
	
		if(!$projectUsers_id) {
		   throw new NotFoundException(__('Invalid user.'));
	    }

	    $this->loadModel('ProjectUsers');
		$this->ProjectUsers->delete($projectUsers_id);
		
		// Set default project to null.
		$this->loadModel('User');

		$user = $this->User->read(null, $userId);
		
		if(isset($user['User']['default_project']) && ($user['User']['default_project'] == $project_id)) {
			$this->User->saveField('default_project', null);
		}
		
		$this->Session->setFlash(__('The user has been removed.'));
		
		return $this->redirect($this->referer());
	}
	
	public function admin_delete($id = null) {
		$this->Project->id = $id;
		
		if (!$this->Project->exists()) {
            $this->Session->setFlash(__('Invalid project.'));
			return $this->redirect(array('action' => 'index'));
        }
		
		$project = $this->Project->findById($id);
		if($project['Project']['user_id'] != AuthComponent::user('id')) {
			$this->Session->setFlash(__('You are not authorized to delete this project.'));
			return $this->redirect(array('action' => 'index'));
		}
		
		if($this->Project->delete($id, true)) {
			$this->Session->setFlash(__('The project has been deleted.'));
		
			$this->loadModel('ProjectUsers');
			$this->ProjectUsers->deleteAll(array('ProjectUsers.project_id' => $id), true);
		
			$this->loadModel('Ticket');
			$this->Ticket->deleteAll(array('Ticket.project_id' => $id), true);
		
			$this->loadModel('State');
			$this->State->deleteAll(array('State.project_id' => $id), true);
		
			return $this->redirect(array('action' => 'index', AuthComponent::user('id')));
		}else{
			$this->Session->setFlash(__('Unable to create delete the project.'));
		}
	}
}
