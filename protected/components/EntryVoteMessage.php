<?php

class EntryVoteMessage {

	private $_score;
	private $_message;
	private $_positive;
	private $_operationStatus;

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

	public function setOperationStatus($status) {
		$status = (int)$status;
		if ($status != 1 || $status != 0) {
			throw new InvalidArgumentException("Operation status field must be true or false");
		}
		$this->_operationStatus = $status;
	}

	public function getOperationStatus() {
		if (isset($this->_operationStatus)) {
			return $this->_operationStatus;
		}

		return null;
	}

	public function __toString() {
		$arr = array(
			'score' => $this->_score,
			'message' => $this->_message,
			'positive' => $this->_positive,
			'operationStatus' => $this->_operationStatus,
		);

		return json_encode($arr);
	}

} 