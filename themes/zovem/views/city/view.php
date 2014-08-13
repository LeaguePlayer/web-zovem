<?php
$this->breadcrumbs=array(
	'Cities'=>array('index'),
	$model->title,
);

<h1>View City #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'counry_id',
		'title',
		'status',
		'sort',
		'create_time',
		'update_time',
	),
)); ?>
