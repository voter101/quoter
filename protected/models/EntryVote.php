<?php

/**
 * @property integer $entry_id
 * @property string  $ip
 * @property integer $positive
 *
 * The followings are the available model relations:
 * @property Entry   $entry
 */
class EntryVote extends CActiveRecord {
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'entry_vote';
	}

	public function primaryKey() {
		return 'entry_id';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		return array(
			array(
				'entry_id, ip, positive',
				'required'
			),
			array(
				'entry_id, positive',
				'numerical',
				'integerOnly' => true
			),
			array(
				'ip',
				'length',
				'max' => 48
			),
			array(
				'entry_id, ip, positive',
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
			'entry' => array(
				self::BELONGS_TO,
				'Entry',
				'entry_id'
			),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'entry_id' => Yii::t("Entry.entry_id", "Entry"),
			'ip' => Yii::t("Entry.ip", "Ip"),
			'positive' => Yii::t("Entry.positive", "Positive"),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('entry_id', $this->entry_id);
		$criteria->compare('ip', $this->ip, true);
		$criteria->compare('positive', $this->positive);

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
