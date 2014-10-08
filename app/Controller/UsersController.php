<?php
App::uses('AppController', 'Controller');
App::uses('Security', 'Utility');
/**
 * Users Controller
 *
 */
class UsersController extends AppController {

	public $helpers = array('Session');

	public $components = array('Paginator', 'DebugKit.Toolbar');
	public $paginate = array('limit' => 25);
	
	/**
	 * Scaffold
	 *
	 * @var mixed
	 */
	public $scaffold;
	
	public function beforeFilter() {
		parent::beforeFilter();
		if (!$this->Auth->loggedIn()) {
		    $this->Auth->authError = false;
		}
		$this->Auth->allow('index','view','login', 'add');
	}

	/**
	 * Create a new account.
	 */
	public function add() {
		if($this->request->is('post')) {
			if($this->alreadyExist($this->request->data['User']['username'])) {
				$this->Session->setFlash(__('Unable to create your account, the user already exists.'));
			}else{
				$this->User->create();
				
				if ($this->User->save($this->request->data)) {
			    	$this->Session->setFlash(__('Your account has been created.'));
					return $this->redirect(array('action' => 'index'));
			    }
		    
				$this->Session->setFlash(__('Unable to create your account.'));
			}
		}
	}
	
	/**
	 * Edit the profile.
	 */
	public function admin_edit($id = null) {
		$this->User->id = $id;
		
		if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user.'));
        }
		
		if($id != AuthComponent::user('id')) {
			$this->Session->setFlash(__('You are not authorized to edit this user.'));
			return $this->redirect(array('action' => 'index'));
		}
		
		if ($this->request->is('post') || $this->request->is('put')) {
			if($this->alreadyExist($this->request->data['User']['username'], $id)) {
				$this->Session->setFlash(__('Unable to update your account, the user already exists.'));
			}else{
				if($this->request->data['User']['newPassword'] != $this->request->data['User']['newPasswordConfirmation']){
					$this->Session->setFlash(__('Unable to update your account, the passwords don\'t match.'));
				}else{
					if($this->User->save($this->request->data, false)) {
		                $this->Session->setFlash(__('Your account has been updated.'));
		            } else {
		                $this->Session->setFlash(__('Unable to update your account.'));
		            }
				}
			}
        } else {
            $this->request->data = $this->User->read(null, $id);
            unset($this->request->data['User']['password']);
        }
	}
	
	/**
	 * Delete account.
	 */
	public function admin_delete($id = null) {
		$this->User->id = $id;
		
		if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user.'));
        }
		
		if($id != AuthComponent::user('id')) {
			$this->Session->setFlash(__('You are not authorized to delete this user.'));
			return $this->redirect(array('action' => 'index'));
		}
		
		$user = $this->User->read(null, $id);
				
		// Check if the user owns a project. 
		$isOwner = false;
		if(!empty($user['Projects'])) {
			foreach($user['Projects'] as $project) {
				if($project['user_id'] == AuthComponent::user('id')) {
					$isOwner = true;
					break;
				}
			}
		}
		
		if($isOwner) {
			$this->Session->setFlash(__('Transfer your projects rights first (edit related projects).'));
			return $this->redirect(array('action' => 'view', $id));
		}else{
			$this->User->Ticket->updateAll(array('Ticket.user_id' => null), array('Ticket.user_id' => $id));		
						
			$this->User->delete($id);
			$this->Session->destroy();
		    $this->Session->setFlash('You account has been deleted.');		
			$this->redirect(array('action' => 'login', 'admin' => false));
		}
	}
	
	/**
	 * Display the list of users.
	 */
	public function index() {
		$this->Paginator->settings = $this->paginate;
		$this->set('users', $this->Paginator->paginate('User'));
	}
	
	/**
	 * Display the list of users.
	 */
	public function admin_index() {
		$this->Paginator->settings = $this->paginate;
		$this->set('users', $this->Paginator->paginate('User'));
	}
	
	/**
	 * Display the user data.
	 */
	public function view($id = null) {
		if(!$id) {
			throw new NotFoundException(__('Invalid user'));
		}

		$user = $this->User->findById($id);
		if (!$user) {
			throw new NotFoundException(__('Invalid user'));
		}
		
		$this->set('user', $user);
	}
	
	/**
	 * Display the user data.
	 */
	public function admin_view($id = null) {
		$this->view($id);
	}
	
	/**
	 * Log the user in.
	 */
	function login() {
		if($this->request->is('post')) {
			if($this->Auth->login()) {
	            return $this->redirect('/');
	        } else {
	            $this->Session->setFlash(__('Invalid username or password.'),
					                'default',
					                array(),
					                'auth'
	            );
	        }
	    }
	}
	
	/**
	 * Log the user out.
	 */
	function logout() {
		$this->admin_logout();
	}

	/**
	 * Log the user out.
	 */
	function admin_logout() {
		$this->Session->destroy();
	    $this->Session->setFlash('You are logged out.');		
		$this->redirect(array('action' => 'login', 'admin' => false));
	}
	
	/**
	 * Check if the user already exists in the database.
	 */
	public function alreadyExist($username, $id = null) {
		if(!$id) {
			return $this->User->find('count', array(
		            	'conditions' => array('username' => $username),
			            'recursive' => -1
		        	)) > 0;
		}else{
			return $this->User->find('count', array(
		            	'conditions' => array('username' => $username, 'id !=' => $id),
			            'recursive' => -1
		        	)) > 0;
		}
	}
	
	public function isAuthorized() {
		return true;
	}
}
