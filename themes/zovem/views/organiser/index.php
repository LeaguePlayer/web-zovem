<?php
/* @var $this OrganiserController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Organisers',
);

$this->menu=array(
	array('label'=>'Create Organiser', 'url'=>array('create')),
	array('label'=>'Manage Organiser', 'url'=>array('admin')),
);
?>

<h1>Organisers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
