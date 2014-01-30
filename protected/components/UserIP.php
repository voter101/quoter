<?php
/**
 * Created by PhpStorm.
 * User: voter101
 * Date: 30.01.14
 * Time: 11:05
 */

class UserIP {

	private function __construct() {

	}

	public static function getUserIP() {
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}

} 