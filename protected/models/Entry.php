<?php

/**
 * This is the model class for table "entry".
 *
 * The followings are the available columns in table 'entry':
 * @property integer $id
 * @property string $content
 * @property string $additional_content
 * @property string $modified
 * @property string $created
 * @property integer $score
 * @property string $author
 * @property integer $type
 * @property integer $deleted
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

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
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
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array(
				'id, content, additional_content, modified, score, author, type, deleted',
				'safe',
				'on' => 'search'
			),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'entryVotes' => array(
				self::HAS_MANY,
				'EntryVote',
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
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('content', $this->content, true);
		$criteria->compare('additional_content', $this->additional_content, true);
		$criteria->compare('modified', $this->modified, true);
		$criteria->compare('score', $this->score);
		$criteria->compare('author', $this->author, true);
		$criteria->compare('type', $this->type);
		$criteria->compare('deleted', $this->deleted);

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
		$userIP = UserIP::getUserIP();
		$previousVotes = EntryVote::model()->findAll('ip=:ip', array(
			':ip' => $userIP));
		if ($previousVotes == null) {
			return $this->insertVote($positive, $userIP);
		} elseif (count($previousVotes) > 1) {
			// TODO Resolve situations like this. Idea: delete all votes from this ip and accpet only a new vote
		} else {
			return $this->updateScore($previousVotes[0], $positive);
		}

		return false; // In case any of if-statements didn't work
	}

	private function updateScore(EntryVote $previousVote, $positive) {
		if ($positive != $previousVote->positive) {
			$previousVote->positive = $positive;
		} else {
			return true;
		}

		$previousVote->save();
		$this->handleScore($positive);

		return true;
	}

	private function insertVote($positive, $ip) {
		$vote = new EntryVote();
		$vote->id = $this->id;
		$vote->ip = $ip;
		$vote->possitive = (int)$positive;
		$vote->save();

		if (!$vote->save()) {
			throw new ScoreHandlingException("I can't save entry after inserting vote to database.");
		}
		$this->handleScore($positive);

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

		if ($this->save() == false) {
			throw new ScoreHandlingException("Couldn't save an entry after changing a score.");
		}
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Entry the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

}
