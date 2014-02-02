<?php

/**
 * This is the model class for table "entry_vote".
 *
 * The followings are the available columns in table 'entry_vote':
 *
 * @property integer $id
 * @property string  $ip
 * @property integer $positive
 *
 * The followings are the available model relations:
 * @property Entry   $id0
 */
class EntryVote extends CActiveRecord {
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'entry_vote';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		return array(
			array(
				'id, ip, positive',
				'required'
			),
			array(
				'id, positive',
				'numerical',
				'integerOnly' => true
			),
			array(
				'ip',
				'length',
				'max' => 48
			),
			array(
				'id, ip, positive',
				'safe',
				'on' => 'search'
			),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		return array(
			'id0' => array(
				self::BELONGS_TO,
				'Entry',
				'id'
			),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'ip' => 'Ip',
			'positive' => 'Positive',
		);
	}

	/**
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('ip', $this->ip, true);
		$criteria->compare('positive', $this->possitive);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 *
	 * @param string $className active record class name.
	 *
	 * @return EntryVote the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
}
