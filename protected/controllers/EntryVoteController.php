<?php

class EntryVoteController extends Controller
{
	public function actionDelete()
	{
		$this->render('delete');
	}

	public function actionVoteDown()
	{
		$this->render('voteDown');
	}

	public function actionVoteUp()
	{
		$this->render('voteUp');
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}