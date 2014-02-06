<?php
require_once "database.php";
return array(
	'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
	'name' => 'Quoter',

	'preload' => array('log'),

	'import' => array(
		'application.models.*',
		'application.components.*',
	),

	'modules' => array(
		'gii' => array(
			'class' => 'system.gii.GiiModule',
			'password' => 'trololo',
			'ipFilters' => array(
				'127.0.0.1',
				'::1'
			),
		),
	),

	// application components
	'components' => array(
		'clientScript' => array(
			'packages' => array(
				'jquery' => array(
					'baseUrl' => '//ajax.googleapis.com/ajax/libs/jquery/1/',
				    'js' => array('jquery.min.js'),
				),
			),
		),
		'user' => array(
			'allowAutoLogin' => true,
		),
		'urlManager' => array(
			'urlFormat' => 'path',
			'showScriptName' => false,
			'rules' => array(
				'' => 'entry',
				'<id:\d+>' => 'entry/view',
				'<type:\w+>' => 'entry/viewByType',
				'<controller:\w+>/<id:\d+>' => '<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
				'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
			),
		),
		'db' => $db,
		// This should be configured in database.php included above
		'errorHandler' => array(
			'errorAction' => 'site/error',
		),
		'log' => array(
			'class' => 'CLogRouter',
			'routes' => array(
				array(
					'class' => 'CFileLogRoute',
					'levels' => 'error, warning',
				),
			),
		),
	    'entryScoreManager' => array('class'  => 'EntryScoreManager'),
	),

	'params' => array(
		'adminEmail' => 'webmaster@example.com',
	),

	//'theme' => 'basic',
);
