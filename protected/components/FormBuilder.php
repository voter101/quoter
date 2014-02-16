<?php

/**
 * Make forms with less code
 */
class FormBuilder {

	/**
	 * @param       $model
	 * @param array $inputs array of FormBuilderInputs
	 * @param bool  $ajaxValidation
	 * @param null  $submitText Default: text from internationalization library
	 */
	public static function BuildForm($model, array $inputs, $ajaxValidation = true, $submitText = null) {

	}

	public static function GetInput($model, $attribute, $fieldType, array $labelOptions = null, array $fieldOptions = null, array $errorOptions = null) {
		return new FormBuilderInput($model, $attribute, $fieldType, $labelOptions, $fieldOptions, $errorOptions);
	}

} 