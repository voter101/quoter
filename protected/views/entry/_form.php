<?php
/* @var $this EntryController */
/* @var $model Entry */
/* @var $form CActiveForm */
?>

<div class="form">

	<?php $form = $this->beginWidget('CActiveForm', array(
		'id' => 'entry-form',
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation' => false,
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

	<div class="row">
		<?php echo $form->labelEx($model, 'additional_content'); ?>
		<?php echo $form->textArea($model, 'additional_content', array(
			'rows' => 6,
			'cols' => 50
		)); ?>
		<?php echo $form->error($model, 'additional_content'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'created'); ?>
		<?php echo $form->textField($model, 'created'); ?>
		<?php echo $form->error($model, 'created'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'score'); ?>
		<?php echo $form->textField($model, 'score'); ?>
		<?php echo $form->error($model, 'score'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'author'); ?>
		<?php echo $form->textField($model, 'author', array(
			'size' => 60,
			'maxlength' => 64
		)); ?>
		<?php echo $form->error($model, 'author'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'type'); ?>
		<?php echo $form->textField($model, 'type'); ?>
		<?php echo $form->error($model, 'type'); ?>
	</div>

	<?php
	// @TODO status should be a dropdown
	// @TODO status is only for admins
	?>
	<div class="row">
		<?php echo $form->labelEx($model, 'status'); ?>
		<?php echo $form->textField($model, 'status'); ?>
		<?php echo $form->error($model, 'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->