<?php
require_once "database.php";
return CMap::mergeArray(require(dirname(__FILE__) . '/main.php'), array(
		'components' => array(
			'fixture' => array(
				'class' => 'system.test.CDbFixtureManager',
			),
			/* uncomment the following to provide test database connection
			'db'=> $dbTest,
			*/
		),
	));
