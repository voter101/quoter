<?php

class EntryScoreManager extends CComponent {

	/**
	 * @var Entry
	 */
	private $_entry;

	public function init() {

	}

	public function Vote(Entry $entry, $positive) {
		if ($entry == null) {
			throw new CException("You didn't passed Entry object to Score Manager");
		}
		$this->_entry = $entry;
		$previousVotes = $this->getPreviousVotes();
		if ($previousVotes == null) {
			return $this->insertVote($positive);
		} elseif (count($previousVotes) > 1) {
			$this->resolveMultipleVotesScore($previousVotes);

			return $this->Vote($this->_entry, $positive);
		} else {
			return $this->updateScore($previousVotes[0], $positive);
		}
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
		$this->_entry->saveWithRelated(array(
			'entryVotes' => array('append' => true)
		));

		return true;
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
			return true;
		}

		$previousVote->positive = $positive;
		$previousVote->save();
		$this->handleEntryScore($positive, true);
		$this->_entry->save();

		return true;
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
}