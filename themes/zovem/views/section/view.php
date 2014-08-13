<?php
$this->breadcrumbs=array(
	'Sections'=>array('index'),
	$model->title,
);

<h1>View Section #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'icon',
		'status',
		'sort',
		'create_time',
		'update_time',
		'node_id',
	),
)); ?>
