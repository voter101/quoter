<?php
/* @var $this EntryController */
/* @var $dataProvider CActiveDataProvider */

$this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>
