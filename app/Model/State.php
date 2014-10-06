<?php
App::uses('AppModel', 'Model');
/**
 * State Model
 *
 * @property Project $Project
 * @property StateTicket $StateTickets
 */
class State extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'state';

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
				'message' => 'The maximum length of the state name is 30 characters.',
				'allowEmpty' => false,
				'required' => false
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'minLength' => array(
				'rule' => array('minLength', 3),
				'message' => 'The minimum length of the state name is 3 characters.',
				'allowEmpty' => false,
				'required' => true
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Project' => array(
			'className' => 'Project',
			'foreignKey' => 'project_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Tickets' => array(
			'className' => 'Ticket',
			'foreignKey' => 'state_id'
		)
	);

}
