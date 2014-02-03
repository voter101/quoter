<?php

/**
 * This is the model class for table "entry".
 *
 * The followings are the available columns in table 'entry':
 *
 * @property integer     $id
 * @property string      $content
 * @property string      $additional_content
 * @property string      $modified
 * @property string      $created
 * @property integer     $score
 * @property string      $author
 * @property integer     $type
 * @property integer     $deleted
 *
 * The followings are the available model relations:
 * @property EntryVote[] $entryVotes
 */
class Entry extends CActiveRecord {

	// Types enums
	const TEXT = 0;

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

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		return array(
			array(
				'content, created',
				'required'
			),
			array(
				'score, type, deleted',
				'numerical',
				'integerOnly' => true
			),
			array(
				'author',
				'length',
				'max' => 64
			),
			array(
				'additional_content',
				'safe'
			),
			array(
				'id, content, additional_content, score, author, type',
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
			'id' => 'ID',
			'content' => 'Content',
			'additional_content' => 'Additional Content',
			'modified' => 'Modified',
			'created' => 'Created',
			'score' => 'Score',
			'author' => 'Author',
			'type' => 'Type',
			'deleted' => 'Deleted',
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

		$criteria->compare('id', $this->id);
		$criteria->compare('content', $this->content, true);
		$criteria->compare('additional_content', $this->additional_content, true);
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

	public function updateVote($positive) {
		$previousVotes = EntryVote::model()->findAll('ip=:ip AND entry_id=:id', array(
			':ip' => UserIP::getUserIP(),
		    ':id' => $this->id,
		));
		if ($previousVotes == null) {
			return $this->insertVote($positive);
		} elseif (count($previousVotes) > 1) {
			// TODO Resolve situations like this. Idea: delete all votes from this ip and accept only a new vote
		} else {
			return $this->updateScore($previousVotes[0], $positive);
		}

		return false; // In case any of if-statements didn't work
	}

	private function updateScore(EntryVote $previousVote, $positive) {
		if ($positive == $previousVote->positive) {
			return true;
		}

		$previousVote->positive = $positive;
		$previousVote->save();
		$this->handleScore($positive, true);
		$this->save();

		return true;
	}

	private function insertVote($positive) {
		$vote = new EntryVote();
		$vote->entry_id = (int)$this->id;
		$vote->ip = UserIP::getUserIP();
		$vote->positive = (int)$positive;
		$this->handleScore($positive);
		$this->entryVotes = array($vote);
		$this->saveWithRelated(array(
			'entryVotes' => array('append' => true)
		));

		return true;
	}

	private function handleScore($positive, $update = false) {
		if ($update == true) {
			$modifier = 2;
		} else {
			$modifier = 1;
		}

		if ($positive == 1) {
			$this->score += $modifier;
		} else {
			$this->score -= $modifier;
		}
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
