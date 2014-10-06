<?php
App::uses('AppModel', 'Model');
/**
 * Project Model
 *
 * @property State $State
 * @property ProjectUserModel $ProjectUsers
 */
class ProjectUsers extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'project_users';

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'joinTable' => 'project_users',
			'foreignKey' => 'user_id',
			'associationForeignKey' => 'user_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		),
		'Project' => array(
			'className' => 'Project',
			'joinTable' => 'project_users',
			'foreignKey' => 'project_id',
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

}
