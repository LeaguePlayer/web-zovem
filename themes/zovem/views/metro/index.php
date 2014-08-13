<?php
/* @var $this MetroController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Metros',
);

$this->menu=array(
	array('label'=>'Create Metro', 'url'=>array('create')),
	array('label'=>'Manage Metro', 'url'=>array('admin')),
);
?>

<h1>Metros</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
