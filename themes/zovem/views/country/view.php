<?php
$this->breadcrumbs=array(
	'Countries'=>array('index'),
	$model->title,
);

<h1>View Country #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'status',
		'sort',
		'create_time',
		'update_time',
	),
)); ?>
