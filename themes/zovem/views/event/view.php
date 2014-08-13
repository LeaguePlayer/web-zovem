<?php
$this->breadcrumbs=array(
	'Events'=>array('index'),
	$model->id,
);

<h1>View Event #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'template_id',
		'contents_id',
		'user_id',
		'status',
		'sort',
		'create_time',
		'update_time',
		'node_id',
	),
)); ?>
