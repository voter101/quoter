<?php

/**
 * @property integer     $id
 * @property string      $content
 * @property string      $modified
 * @property string      $created
 * @property integer     $score
 * @property string      $author
 * @property integer     $type
 * @property string      $status
 *
 * The followings are the available model relations:
 * @property EntryVote[] $entryVotes
 */
class Entry extends CActiveRecord {

	// Types enums
	const TEXT = 0;
	// Status enums
	const PENDING = 'pending';
	const QUEUED = 'queued';
	const PUBLISHED = 'published';

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'entry';
	}

	public function behaviors() {
		return array(
			'ESaveRelatedBehavior' => array(
				'class' => 'application.components.ESaveRelatedBehavior'
			)
		);
	}

	public function beforeSave() {
		if (parent::beforeSave()) {
			$this->modified = date("Y-m-d H:i:s");

			return true;
		}

		return false;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		return array(
			array(
				'content',
				'required'
			),
			array(
				'score, type',
				'numerical',
				'integerOnly' => true
			),
			array(
				'author',
				'length',
				'max' => 64
			),
			array(
				'status',
				'length',
				'max' => 16
			),
			array(
				'id, content, score, author, type',
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
			'entryVotes' => array(
				self::HAS_MANY,
				'EntryVote',
				'entry_id'
			),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => Yii::t("Entry.id", 'ID'),
			'content' => Yii::t("Entry.content", "Content"),
			'modified' => Yii::t("Entry.modified", "Modified"),
			'created' => Yii::t("Entry.created", "Created"),
			'score' => Yii::t("Entry.score", "Score"),
			'author' => Yii::t("Entry.author", "Author"),
			'type' => Yii::t("Entry.type", "Type"),
			'status' => Yii::t("Entry.status", "Status"),
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
	 * @todo Search only published entries
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search() {

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('content', $this->content, true);
		$criteria->compare('score', $this->score);
		$criteria->compare('author', $this->author, true);
		$criteria->compare('type', $this->type);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	public function findRandom(array $params = array()) {
		$query = "SELECT * FROM {$this->tableName()} JOIN
            (SELECT CEIL(RAND() *
                (SELECT MAX(id)
                    FROM {$this->tableName()})) AS id
            ) AS rnd
            USING (id)";
		for ($i = 0; $i < 5; $i++) {
			$result = self::model()->findBySql($query, $params);
			if ($result !== null) {
				return $result;
			}
		}

		return null;
	}

	/**
	 * @return EntryVoteMessage
	 */
	public function Vote($positive) {
		return Yii::app()->entryScoreManager->Vote($this, $positive);
	}

	public static function listStatuses() {
		return array(
			self::PENDING => Yii::t('Entry.status.pending', 'Pending'),
			self::QUEUED => Yii::t('Entry.status.queued', 'Queued'),
			self::PUBLISHED => Yii::t('Entry.status.published', 'Published'),
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 *
	 * @param string $className active record class name.
	 *
	 * @return Entry the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

}
