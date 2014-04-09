<?php

Yii::import('application.models.User');
Yii::import('application.repositories.UserRepository');

class UserRepositoryTest extends CDbTestCase {

	/**
	 * @var UserRepository
	 */
	public $repository;

	protected $fixtures = [
		'users' => 'User'
	];

	public function setUp() {
		$this->repository = new UserRepository();
		parent::setUp();
	}

	public function testGetExistingUser() {
		$user = $this->repository->getUser(1);
		$this->assertTrue($user != null);
		$this->assertTrue($user instanceof User);
	}

	public function testGetNonExistingUser() {
		$user = $this->repository->getUser(9001);
		$this->assertTrue($user === 0);
	}

} 