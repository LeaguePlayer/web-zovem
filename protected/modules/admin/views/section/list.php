<?php
$this->menu=array(
	array('label'=>'Добавить','url'=>array('create')),
);
?>

<h1>Управление рубриками</h1>

    <?php if(Yii::app()->user->hasFlash('message')):?>
        <div class="alert alert-success">
            <?php echo Yii::app()->user->getFlash('message'); ?>
        </div>
    <?php endif; ?>
    
<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'section-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'type'=>TbHtml::GRID_TYPE_HOVER,
    'afterAjaxUpdate'=>"function() {sortGrid('section')}",
    'rowHtmlOptionsExpression'=>'array(
        "id"=>"items[]_".$data->id,
        "class"=>"status_".(isset($data->status) ? $data->status : ""),
    )',
	'columns'=>array(
		'title',
		array(
			'header'=>'Иконка',
			'type'=>'raw',
			'value'=>'TbHtml::image($data->imgBehaviorIcon->getImageUrl())'
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{update}{delete}',
		    'buttons'=>array
		    (
		        'delete' => array
		        (
		            'url'=>'Yii::app()->createUrl("admin/section/delete", array("id"=>$data->id))',
		        ),
		        'update' => array
		        (
		            'url'=>'Yii::app()->createUrl("admin/section/update", array("id"=>$data->id))',
		        ),
		     ),
		),
	),
)); ?>

<?php if($model->hasAttribute('sort')) Yii::app()->clientScript->registerScript('sortGrid', 'sortGrid("section");', CClientScript::POS_END) ;?>