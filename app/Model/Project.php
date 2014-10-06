<?php
App::uses('AppModel', 'Model');
/**
 * Project Model
 *
 * @property State $State
 * @property ProjectUserModel $ProjectUsers
 */
class Project extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'project';

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
		'name' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 30),
				'message' => 'The maximum length of the project name is 30 characters.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'minLength' => array(
				'rule' => array('minLength', 3),
				'message' => 'The minimum length of the project name is 3 characters.',
				'allowEmpty' => false,
				'required' => true
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'State' => array(
			'className' => 'State',
			'foreignKey' => 'project_id',
			'order' => 'State.state_order ASC'
		),
		'Ticket' => array(
			'className' => 'Ticket',
			'foreignKey' => 'project_id'
		)
	);


/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Users' => array(
			'className' => 'User',
			'joinTable' => 'project_users',
			'foreignKey' => 'project_id',
			'associationForeignKey' => 'user_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);

}
