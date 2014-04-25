<?php

class AuthorizeService {

	private $_userDb;
	private $_ipGetter;

	const LOGIN_TIME = 1800; // Code won't be reusable

	public function __construct(CActiveRecord $userDb, UserIPGetter $IPGetter) {
		$this->_userDb = $userDb;
		$this->_ipGetter = $IPGetter;
	}

	public function getLoggedInUser() {
		try {
			$this->checkAuthorization();
			$this->refreshTimeToken();
			return $this->_userDb->findByPk($_SESSION['auth_id']);
		} catch (AuthorizeServiceException $e) {
			return null;
		}
	}

	private function checkAuthorization() {
		$error = false;
		if ($this->_ipGetter->getUserIP() !== $_SESSION['auth_ip']) {
			$error = true;
		}
		if ((int)$_COOKIE['auth'] !== (int)$_SESSION['auth_time_token']) {
			$error = true;
		}

		if ($error) {
			throw new AuthorizeServiceException();
		}
	}

	private function refreshTimeToken() {
		$dateTime = new DateTime();
		$timestamp = $dateTime->getTimestamp() + self::LOGIN_TIME;
		setcookie('auth', $timestamp, time() + self::LOGIN_TIME);
		$_SESSION['auth_time_token'] = $timestamp;
	}
}
