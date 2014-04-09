<?php

/**
 * @property integer $id
 * @property string  $email
 * @property string  $password
 * @property string  $salt
 * @property string  $token
 */
class User extends CActiveRecord {
	public function tableName() {
		return 'user';
	}

	public function rules() {
		return array(
			array(
				'email, password, salt',
				'required'
			),
			array(
				'email',
				'length',
				'max' => 256
			),
			array(
				'password',
				'length',
				'max' => 64
			),
			array(
				'salt, token',
				'length',
				'max' => 32
			),
			array(
				'id, email',
				'safe',
				'on' => 'search'
			),
		);
	}

	public function relations() {
		return array();
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t("User.id", "ID"),
			'email' => Yii::t("User.email", "Email"),
			'password' => Yii::t("User.password", "Password"),
			'salt' => Yii::t("User.salt", "Salt"),
			'token' => Yii::t("User.token", "Token"),
		);
	}

	/**
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search() {
		$criteria = new CDbCriteria;
		$criteria->compare('id', $this->id);
		$criteria->compare('email', $this->email, true);
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	/**
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
}
