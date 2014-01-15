<?php

class EntryController extends Controller {

	public $layout = '//layouts/column2';

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
				// allow all users to perform 'index' and 'view' actions
				'actions' => array(
					'index',
					'view',
					'viewByType'
				),
				'users' => array('*'),
			),
			array(
				'allow',
				// allow authenticated user to perform 'create' and 'update' actions
				'actions' => array(
					'create',
					'update'
				),
				'users' => array('@'),
			),
			array(
				'allow',
				// allow admin user to perform 'admin' and 'delete' actions
				'actions' => array(
					'admin',
					'delete'
				),
				'users' => array('admin'),
			),
			array(
				'deny',
				// deny all users
				'users' => array('*'),
			),
		);
	}

	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id),
		));
	}

	public function actionViewByType($type) {
		$criteriaArray = array();
		switch ($type) {
			case 'top':
				$criteriaArray['order'] = 'score DESC';
				break;
			case 'bottom':
				$criteriaArray['order'] = 'score ASC';
				break;
			case 'old':
				$criteriaArray['order'] = 'created ASC';
				break;
			default:
				$criteriaArray['order'] = 'created DESC';
		}
		$criteria = new CDbCriteria($criteriaArray);

		$dataProvider = new CActiveDataProvider('Entry', array(
			'pagination' => array(
				'pageSize' => 10,
			),
			'criteria' => $criteria,
		));

		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionCreate() {
		$model = new Entry;

		$this->performAjaxValidation($model);

		if (isset($_POST['Entry'])) {
			$model->attributes = $_POST['Entry'];
			if ($model->save()) {
				$this->redirect(array(
					'view',
					'id' => $model->id
				));
			}
		}

		$this->render('create', array(
			'model' => $model,
		));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id);

		$this->performAjaxValidation($model);

		if (isset($_POST['Entry'])) {
			$model->attributes = $_POST['Entry'];
			if ($model->save()) {
				$this->redirect(array(
					'view',
					'id' => $model->id
				));
			}
		}

		$this->render('update', array(
			'model' => $model,
		));
	}

	public function actionDelete($id) {
		$this->loadModel($id)->delete();
		if (!isset($_GET['ajax'])) {
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
	}

	public function actionIndex() {
		$this->redirect(array(
			'entry/viewByType',
			'type' => 'new'
		));
	}

	public function actionAdmin() {
		$model = new Entry('search');
		$model->unsetAttributes(); // clear any default values
		if (isset($_GET['Entry'])) {
			$model->attributes = $_GET['Entry'];
		}

		$this->render('admin', array(
			'model' => $model,
		));
	}

	public function loadModel($id) {
		$model = Entry::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}
		return $model;
	}

	protected function performAjaxValidation($model) {
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'entry-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
