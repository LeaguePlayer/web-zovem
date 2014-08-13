<?php
$this->breadcrumbs=array(
	'Metros'=>array('index'),
	$model->title,
);

<h1>View Metro #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'city_id',
		'title',
		'status',
		'sort',
		'create_time',
		'update_time',
	),
)); ?>
