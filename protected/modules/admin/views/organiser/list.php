<?php
$this->menu=array(
	array('label'=>'Добавить','url'=>array('create')),
);
?>

<h1>Управление устроителями</h1>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'organiser-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'type'=>TbHtml::GRID_TYPE_HOVER,
    'afterAjaxUpdate'=>"function() {sortGrid('organiser')}",
    'rowHtmlOptionsExpression'=>'array(
        "id"=>"items[]_".$data->id,
        "class"=>"status_".(isset($data->status) ? $data->status : ""),
    )',
	'columns'=>array(
		array(
			'name' => 'user',
			'value' => '$data->user->getFullName()',
			'type' => 'raw',
		),
		'title',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{update}{delete}',
		    'buttons'=>array
		    (
		        'delete' => array
		        (
		            'url'=>'Yii::app()->createUrl("admin/organiser/delete", array("id"=>$data->id))',
		        ),
		        'update' => array
		        (
		            'url'=>'Yii::app()->createUrl("admin/organiser/update", array("id"=>$data->id))',
		        ),
		     ),
		),
	),
)); ?>

<?php if($model->hasAttribute('sort')) Yii::app()->clientScript->registerScript('sortGrid', 'sortGrid("organiser");', CClientScript::POS_END) ;?>