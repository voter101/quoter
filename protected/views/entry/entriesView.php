<?php
/* @var $this EntryController */
/* @var $data Entry */
?>

<article class="entry">

	<?php echo CHtml::link(CHtml::encode('#' . $data->id), array(
		'view',
		'id' => $data->id
	)); ?>
	<br/>

	<?php echo CHtml::encode($data->content); ?>
	<br/>

	<?php echo CHtml::encode($data->modified); ?>

	<b><?php echo CHtml::encode($data->getAttributeLabel('score')); ?>:</b>
	<?php echo CHtml::encode($data->score); ?>
	<br/>

	<b><?php echo CHtml::encode($data->getAttributeLabel('author')); ?>:</b>
	<?php echo CHtml::encode($data->author); ?>
	<br/>

</article>