<?php

// FIXME refactoring
class EntryScoreManager extends CComponent {

	const COOKIE_TTL = 43200; // Month: 60 * 24 * 30
	const COOKIE_PREFIX = 'entryVote';

	/**
	 * @var Entry
	 */
	private $_entry;
	/**
	 * @var EntryVoteMessage
	 */
	private $_voteMessage;

	public function init() {

	}

	/**
	 * @return EntryVoteMessage
	 * @throws CException
	 */
	public function Vote(Entry $entry, $positive) {
		if ($entry == null) {
			throw new InvalidArgumentException("You didn't passed Entry object to Score Manager");
		}
		$this->_entry = $entry;
		$previousVotes = $this->getPreviousVotes();
		$this->_voteMessage = new EntryVoteMessage;
		$this->_voteMessage->setPositive($positive);
		$this->_voteMessage->setOperationStatus(false);
		if ($this->voteActionOnPreviousVotes($previousVotes, $positive) == true) {
			if (self::SetUpCookie($this->_entry->id, $positive) == true) {
				$this->_voteMessage->setOperationStatus(true);
			}
		}
		$this->_voteMessage->setScore($this->_entry->score);

		return $this->_voteMessage;
	}

	private function voteActionOnPreviousVotes(array $previousVotes, $positive) {
		if ($previousVotes == null) {
			return $this->insertVote($positive);
		} elseif (count($previousVotes) == 1) {
			return $this->updateScore($previousVotes[0], $positive);
		}
		$this->resolveMultipleVotesScore($previousVotes);

		return $this->Vote($this->_entry, $positive);

	}

	private function getPreviousVotes() {
		return EntryVote::model()->findAll('ip=:ip AND entry_id=:id', array(
			':ip' => UserIP::getUserIP(),
			':id' => $this->_entry->id,
		));
	}

	private function insertVote($positive) {
		$vote = new EntryVote();
		$vote->entry_id = (int)$this->_entry->id;
		$vote->ip = UserIP::getUserIP();
		$vote->positive = (int)$positive;
		$this->handleEntryScore($positive);
		$this->_entry->entryVotes = array($vote);
		if ($this->_entry->saveWithRelated(array('entryVotes' => array('append' => true))) == true) {
			$this->_voteMessage->setMessage(Yii::t("EntryVote.voteInsert.success", "Your vote has been saved"));

			return true;
		}
		$this->_voteMessage->setMessage(Yii::t("EntryVote.voteInsert.failure", "Your vote couldn't be saved"));

		return false;
	}

	private function resolveMultipleVotesScore(array $previousVotes) {
		$votesSum = 0;
		foreach ($previousVotes as $vote) {
			if ($vote->positive == 1) {
				$votesSum++;
			} else {
				$votesSum--;
			}
			$vote->delete();
		}
		$this->_entry->score = $this->_entry->score - $votesSum;
	}

	private function updateScore(EntryVote $previousVote, $positive) {
		if ($positive == $previousVote->positive) {
			$this->_voteMessage->setMessage(Yii::t("EntryVote.voteUpdate.noActionNeeded", "Sorry, but you have already voted"));

			return true;
		}

		$previousVote->positive = $positive;
		if ($previousVote->save() == false) {
			return false;
		}
		$this->handleEntryScore($positive, true);
		if ($this->_entry->save() == true) {
			$this->_voteMessage->setMessage(Yii::t("EntryVote.voteUpdate.success", "Your vote has been updated"));

			return true;
		}

		$this->_voteMessage->setMessage(Yii::t("EntryVote.voteUpdate.failure", "Your vote couldn't be updated"));

		return false;
	}

	private function handleEntryScore($positive, $update = false) {
		if ($update == true) {
			$modifier = 2;
		} else {
			$modifier = 1;
		}

		if ($positive == 1) {
			$this->_entry->score += $modifier;
		} else {
			$this->_entry->score -= $modifier;
		}
	}

	public static function SetUpCookie($id, $positive) {
		return setcookie(self::COOKIE_PREFIX . $id, $positive, time() + self::COOKIE_TTL, '/');
	}

	public static function GetVoteCookieSign($id) {
		if (isset($_COOKIE[self::COOKIE_PREFIX . $id])) {
			return (int)$_COOKIE[self::COOKIE_PREFIX . $id];
		}

		return null;
	}
}