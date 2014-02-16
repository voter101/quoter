<?php

class FormBuilderInput {

	public function __construct($model, $attribute, $fieldType, array $labelOptions = null, array $fieldOptions = null, array $errorOptions = null) {

	}

	/**
	 * @return string
	 */
	private function getLabel() {

	}

	/**
	 * @return string
	 */
	private function getField() {

	}

	/**
	 * @return string
	 */
	private function getError() {

	}

	public function __toString() {
		return $this->getLabel() . $this->getField() . $this->getError();
	}

} 