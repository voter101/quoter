<?php

class EntryVoteMessage {

	private $_score;
	private $_message;
	private $_positive;

	public function setScore($score) {
		if (!is_numeric($score)) {
			throw new InvalidArgumentException("Score field must be a numeric value");
		}
		$this->_score = $score;
	}

	public function setMessage($message) {
		$this->_message = $message;
	}

	public function setPositive($positive) {
		$positive = (int)$positive;
		if ($positive != 1 || $positive != 0) {
			throw new InvalidArgumentException("Positive field must be true or false");
		}
		$this->_positive = $positive;
	}

	public function __toString() {
		$arr = array(
			'score' => $this->_score,
		    'message' => $this->_message,
		    'positive' => $this->_positive,
		);
		return json_encode($arr);
	}

} 