<?php

/**
 * Difference between add and create action:
 *  * Add - used by users. Doesn't require admin access. Can be used to add entry to moderation
 *  * Create - used by admins. It doesn't hide any field used in database and let set every possible state of entry
 */
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
					'add',
					'index',
					'view',
					'viewByType',
					'vote',
				),
				'users' => array('*'),
			),
			array(
				'allow',
				// allow admin user to perform 'admin' and 'delete' actions
				'actions' => array(
					'create',
			        'update',
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
		$entry = $this->service()->get($id);
		$this->render('view', array(
			'model' => $entry
		));
	}

	public function actionViewByType($type = 'new') {
		$criteria = new CDbCriteria();
		$criteria->condition = 'status=:status';
		$criteria->params = array(':status'=>Entry::PUBLISHED);
		switch ($type) {
			case Yii::t("Entry.top", 'top'):
				$order = 'score DESC';
				break;
			case Yii::t("Entry.bottom", 'bottom'):
				$order = 'score ASC';
				break;
			case Yii::t("Entry.old", 'old'):
				$order = 'created ASC';
				break;
			case Yii::t("Entry.new", "new"):
			default:
				$order = 'created DESC';
		}
		$criteria->order = $order;

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

	public function actionAdd() {
		$model = new Entry;

		$this->performAjaxValidation($model);

		if (isset($_POST['Entry'])) {
			$model->attributes = $_POST['Entry'];
			if ($model->save()) {
				$this->redirect(array(
					'add',
					'success' => 1,
				));
			}
		}

		$this->render('add', array(
			'model' => $model,
		));
	}

	public function actionCreate() {
		$model = new Entry;

		$this->performAjaxValidation($model);

		if (isset($_POST['Entry'])) {
			$model->attributes = $_POST['Entry'];
			if ($model->save()) {
				$this->redirect(array(
					'create',
				    'success' => 1,
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
		$this->forward('viewByType');
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

	public function actionVote($id) {
		if (!isset($_GET['positive'])) {
			die();
		}
		$positive = (int)$_GET['positive'];
		$model = $this->loadModel($id, false);
		if ($model == null) {
			die();
		}
		$transaction = DbUtils::beginTransaction();
		$returnMessage = null;
		try {
			$returnMessage = $model->Vote($positive);
			$transaction->commit();
		} catch (CDbException $e) {
			$transaction->rollback();
		} catch (ScoreHandlingException $e) {
			$transaction->rollback();
		} finally {
			echo $returnMessage;
		}
	}

	/**
	 * @return Entry
	 * @throws CHttpException
	 */
	public function loadModel($id, $throwHTTPException = true) {
		// FIXME Let logged-in users to search any entries!!
		$model = Entry::model()->findByPk($id, 'status=:status', array(':status' => Entry::PUBLISHED));
		if ($model === null && $throwHTTPException) {
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

	private $_service;
	private function service() {
		if (!isset ($this->_service)) {
			$this->_service = new EntriesService(new Entry);
		}
		return $this->_service;
	}
}
