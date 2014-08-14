<?php
$this->menu=array(
	array('label'=>'Добавить','url'=>array('create')),
);
?>

<h1>Управление странами</h1>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'country-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'type'=>TbHtml::GRID_TYPE_HOVER,
    'afterAjaxUpdate'=>"function() {sortGrid('country')}",
    'rowHtmlOptionsExpression'=>'array(
        "id"=>"items[]_".$data->id,
        "class"=>"status_".(isset($data->status) ? $data->status : ""),
    )',
	'columns'=>array(
		'title',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{update}{delete}',
		    'buttons'=>array
		    (
		        'delete' => array
		        (
		            'url'=>'Yii::app()->createUrl("admin/country/delete", array("id"=>$data->id))',
		        ),
		        'update' => array
		        (
		            'url'=>'Yii::app()->createUrl("admin/country/update", array("id"=>$data->id))',
		        ),
		     ),
		),
	),
)); ?>

<?php if($model->hasAttribute('sort')) Yii::app()->clientScript->registerScript('sortGrid', 'sortGrid("country");', CClientScript::POS_END) ;?>