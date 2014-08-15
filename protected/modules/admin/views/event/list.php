<?php
$this->menu=array(
	array('label'=>'Добавить','url'=>array('create')),
);
?>

<h1>Управление анонсами</h1>

    <?php if(Yii::app()->user->hasFlash('message')):?>
        <div class="alert alert-success">
            <?php echo Yii::app()->user->getFlash('message'); ?>
        </div>
    <?php endif; ?>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'event-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'type'=>TbHtml::GRID_TYPE_HOVER,
    'afterAjaxUpdate'=>"function() {sortGrid('event')}",
    'rowHtmlOptionsExpression'=>'array(
        "id"=>"items[]_".$data->id,
        "class"=>"status_".(isset($data->status) ? $data->status : ""),
    )',
	'columns'=>array(
		array(
		    'class'=>'CCheckBoxColumn',
		    'selectableRows' => 1,
		    'checkBoxHtmlOptions' => array('class' => 'checkclass'),
		),
		array(
			'name' => 'current_contents.title',
			'value' => '$data->current_contents->title',
			'type' => 'raw',
		),
		array(
			'name' => 'user',
			'value' => '$data->user->profile->first_name." ".$data->user->profile->last_name',
			'type' => 'raw',
		),
		array(
			'name' => 'current_contents.city',
			'value' => '$data->current_contents->city->title',
			'type' => 'raw',
		),
		array(
			'name'=>'status',
			'type'=>'raw',
			'value'=>'Event::getStatus($data->status)',
			'filter'=>Event::getStatus()
		),
		array(
			'name'=>'create_time',
			'type'=>'raw',
			'value'=>'$data->create_time ? SiteHelper::russianDate($data->create_time).\' в \'.date(\'H:i\', strtotime($data->create_time)) : ""'
		),
		array(
			'name'=>'update_time',
			'type'=>'raw',
			'value'=>'$data->current_contents->update_time ? SiteHelper::russianDate($data->current_contents->update_time).\' в \'.date(\'H:i\', strtotime($data->update_time)) : ""'
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{update}{delete}',
		    'buttons'=>array
		    (
		        'delete' => array
		        (
		            'url'=>'Yii::app()->createUrl("admin/event/delete", array("id"=>$data->id))',
		        ),
		        'update' => array
		        (
		            'url'=>'Yii::app()->createUrl("admin/event/update", array("id"=>$data->id))',
		        ),
		     ),
		),
	),
)); ?>

<div class="well">
	<p>
		<button class="btn btn-danger deleteChecked actionCheched" disabled="disabled">Удалить выбранное</button>
		<button class="btn btn-primary publishChecked actionCheched" disabled="disabled">Опубликовать выбранные</button>
	</p>
</div>

<?php if($model->hasAttribute('sort')) Yii::app()->clientScript->registerScript('sortGrid', 'sortGrid("event");', CClientScript::POS_END) ;?>