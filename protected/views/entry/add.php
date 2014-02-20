<?php
/*
 * The difference between add and create is explained in controller
 */

/* @var $model Entry */
/* @var $this EntryController */
?>
<h1><?php echo Yii::t('Entry.addForm.header', 'Add an entry'); ?></h1>
<?php
$this->renderPartial('_form', array('model' => $model, 'formType' => 'add'));
