<?php

class EntriesService {

	private $_entryDb;

	public function __construct(CActiveRecord $entryDb) {
		$this->_entryDb = $entryDb;
	}

	public function get($id) {
		return $this->_entryDb->findByPk($id);
	}

} 