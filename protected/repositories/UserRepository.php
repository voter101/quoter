<?php

class UserRepository {

	public function getUser($id) {

	}

	public function saveUser(User $user) {
		if (!$user->save()) {
			throw new UserSaveException();
		}

		return true;
	}

} 