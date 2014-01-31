<?php
/**
 * Created by PhpStorm.
 * User: voter101
 * Date: 31.01.14
 * Time: 11:34
 */

class DbUtils {

	/**
	 * @return false|CDbTransaction False if you already have opened transaction
	 */
	public static function beginTransaction() {
		$currentTransaction = Yii::app()->db->getCurrentTransaction();
		return $currentTransaction === null || !$currentTransaction->getActive() ? Yii::app()->db->beginTransaction() : false;
	}

} 