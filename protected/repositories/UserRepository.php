<?php

class UserRepository {

	public function getUser($id) {
		return User::model()->findByPk($id);
	}

	public function saveUser(User $user) {
		if (!$user->save()) {
			throw new UserSaveException();
		}

		return true;
	}

} 