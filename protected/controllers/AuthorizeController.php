<?php

class AuthorizeController extends Controller {

	public function accessRules() {
		return [
			['allow', 'users' => ['*']]
		];
	}

} 