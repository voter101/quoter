<?php

class EntryVoteController extends Controller {

	public function filters() {
		return array(
			'accessControl',
			// perform access control for CRUD operations
			'postOnly + delete',
			// we only allow deletion via POST request
		);
	}

	public function accessRules() {
		return array(
			array(
				'allow',
				'actions' => array(
					'test',
				),
				'users' => array('*'),
			),
			array(
				'allow',
				'actions' => array(
					'delete'
				),
				'users' => array('admin'),
			),
			array(
				'deny',
				'users' => array('*'),
			),
		);
	}

	public function actionDelete() {
		$this->render('delete');
	}

}