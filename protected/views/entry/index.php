<?php
/* @var $this EntryController */
/* @var $dataProvider CActiveDataProvider */

$this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => 'entry',
	'itemsCssClass' => 'entries',
	'itemsTagName' => 'section',
	'tagName' => 'section',
	'template' => '{items}{pager}',
));
