<?php
/*
 * The difference between add and create is explained in controller
 */

/* @var $this EntryController */
/* @var $model Entry */

$this->renderPartial('_form', array('model' => $model, 'formType' => 'create'));
