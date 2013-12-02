<?php
/* @var $this EntryController */
/* @var $model Entry */

$this->breadcrumbs=array(
	'Entries'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Entry', 'url'=>array('index')),
	array('label'=>'Manage Entry', 'url'=>array('admin')),
);
?>

<h1>Create Entry</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>