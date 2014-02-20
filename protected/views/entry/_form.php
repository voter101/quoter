<?php
/* @var $this EntryController */
/* @var $model Entry */
/* @var $form CActiveForm */
/* @var $formType string */
/**
 * @TODO Style-up error messages
 */
?>
<div class="form formEntryAdd">

	<?php $form = $this->beginWidget('CActiveForm', array(
		'id' => 'entry-form',
		'enableAjaxValidation' => true,
	)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model, 'content'); ?>
		<?php echo $form->textArea($model, 'content', array(
			'rows' => 6,
			'cols' => 50
		)); ?>
		<?php echo $form->error($model, 'content'); ?>
	</div>

	<?php if ($formType == 'create') : ?>
	<div class="row">
		<?php echo $form->labelEx($model, 'created'); ?>
		<?php echo $form->textField($model, 'created'); ?>
		<?php echo $form->error($model, 'created'); ?>
	</div>
	<?php endif; ?>

	<?php if ($formType == 'create') : ?>
	<div class="row">
		<?php echo $form->labelEx($model, 'score'); ?>
		<?php echo $form->textField($model, 'score'); ?>
		<?php echo $form->error($model, 'score'); ?>
	</div>
	<?php endif; ?>

	<div class="row">
		<?php echo $form->labelEx($model, 'author'); ?>
		<?php echo $form->textField($model, 'author', array(
			'size' => 60,
			'maxlength' => 64
		)); ?>
		<?php echo $form->error($model, 'author'); ?>
	</div>

	<?php if ($formType == 'create') : ?>
	<div class="row">
		<?php echo $form->labelEx($model, 'type'); ?>
		<?php echo $form->textField($model, 'type'); ?>
		<?php echo $form->error($model, 'type'); ?>
	</div>
	<?php endif; ?>

	<?php if ($formType == 'create') : ?>
	<div class="row">
		<?php echo $form->labelEx($model, 'status'); ?>
		<?php echo $form->dropDownList($model, 'status', Entry::listStatuses()); ?>
		<?php echo $form->error($model, 'status'); ?>
	</div>
	<?php endif; ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('Entry.addForm.create', 'Submit quote') : Yii::t('Entry.addForm.saveChanges', 'Save Changes')); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->