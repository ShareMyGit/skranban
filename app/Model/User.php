<?php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
/**
 * User Model
 *
 * @property ProjectUser $ProjectUsers
 * @property Ticket $Ticket
 */
class User extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'user';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
	
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'username' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 30),
				'message' => 'The maximum length of the username is 30 characters.',
				'allowEmpty' => false,
				'required' => true
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'username' => array(
				'rule' => array('minLength', 3),
				'message' => 'The minimum length of the username is 3 characters.',
				'allowEmpty' => false,
				'required' => true
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'password' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 10),
				'message' => 'The maximum length of the password is 10 characters.',
				'allowEmpty' => false,
				'required' => true
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'minLength' => array(
				'rule' => array('minLength', 3),
				'message' => 'The minimum length of the password is 3 characters.',
				'allowEmpty' => false,
				'required' => true
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'newPassword' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 10),
				'message' => 'The maximum length of the password is 10 characters.',
				'allowEmpty' => true,
				'required' => false
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'minLength' => array(
				'rule' => array('minLength', 3),
				'message' => 'The minimum length of the password is 3 characters.',
				'allowEmpty' => true,
				'required' => false
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'passwordConfirmation' => array(
		        'equaltofield' => array(
            	'rule' => array('equaltofield', 'password'),
            	'message' => 'Require the same value than password field.',
            	//'allowEmpty' => false,
            	//'required' => false,
            	//'last' => false, // Stop validation after this rule
            	'on' => array('create', 'update') // Limit validation to 'create' or 'update' operations
            )
        ),
		'newPasswordConfirmation' => array(
		        'equaltofield' => array(
            	'rule' => array('equaltofield', 'newPassword'),
            	'message' => 'Require the same value than new password field.',
            	'allowEmpty' => true,
				'required' => false,
            	//'last' => false, // Stop validation after this rule
            	'on' => array('create', 'update') // Limit validation to 'create' or 'update' operations
            )
        ),
		'email' => 'email'
	);
	
	public function beforeSave($options = array()) {
	    if(!empty($this->data[$this->alias]['password']) && !empty($this->data[$this->alias]['passwordConfirmation'])) {
			$passwordHasher = new BlowfishPasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['password']);
        }
		if (!empty($this->data[$this->alias]['newPassword']) && !empty($this->data[$this->alias]['newPasswordConfirmation'])) {
			$passwordHasher = new BlowfishPasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['newPassword']);
        }
        return true;
    }

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	function equaltofield($check, $otherfield) {
	    //get name of field
        $fname = '';
        foreach ($check as $key => $value){
            $fname = $key;
            break;
        }
        return $this->data[$this->name][$otherfield] === $this->data[$this->name][$fname];
    }
/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Projects' => array(
			'className' => 'Project',
			'joinTable' => 'project_users',
			'foreignKey' => 'user_id',			
			'associationForeignKey' => 'project_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Ticket' => array(
			'className' => 'Ticket',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
