<?php
class DATABASE_CONFIG {

	public $default = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => '127.0.0.1',
		'login' => 'root',
		'password' => 'root',
		'database' => 'sdr',
		'encoding' => 'utf8'
	);
	public $test = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => '127.0.0.1',
		'login' => 'user',
		'password' => 'password',
		'database' => 'test_database_name',
		'encoding' => 'utf8'
	);
	public $sdr = array(
		'datasource' => 'Database/Mysql',
		'persistent' => true,
		'host' => '127.0.0.1',
		'port' => 3306,
		'login' => 'root',
		'password' => 'root',
		'database' => 'sdr',
		'encoding' => 'utf8'
	);
}
