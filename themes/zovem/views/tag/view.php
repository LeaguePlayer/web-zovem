<?php
$this->breadcrumbs=array(
	'Tags'=>array('index'),
	$model->id,
);

<h1>View Tag #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'value',
		'ref_count',
		'status',
		'sort',
		'create_time',
		'update_time',
		'node_id',
	),
)); ?>
