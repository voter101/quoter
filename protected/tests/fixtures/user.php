<?php
return [
	'user1' => [
	    'email' => 'example@example.com',
	    'password' => CPasswordHelper::hashPassword($salt = CPasswordHelper::generateSalt() . "trololo"),
	    'salt' => $salt,
	    'token' => md5(microtime())
	],
];
