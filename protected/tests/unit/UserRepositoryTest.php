<?php

Yii::import('application.repositories.UserRepository');

class UserRepositoryTest extends CDbTestCase {

	/**
	 * @var UserRepository
	 */
	public $repository;

	public $fixtures = [
		'users' => 'User'
	];

	public function setUp() {
		$this->repository = new UserRepository();
	}

	public function testGetExistingUser() {
		$user = $this->repository->getUser(1);
		$this->assertTrue(true);
		$this->assertTrue($user != null);
		$this->assertTrue($user instanceof User);
	}

	public function testGetNonExistingUser() {
		$user = $this->repository->getUser(9001);
		$this->assertTrue($user === 0);
	}

} 