<?php
/*
 * The difference between add and create is explained in controller
 */

/* @var $this EntryController */
/* @var $model Entry */
?>
<h1><?php Yii::t('Entry.addForm.header', 'Add an entry'); ?></h1>
<?php
$this->renderPartial('_form', array('model' => $model, 'formType' => 'create'));
