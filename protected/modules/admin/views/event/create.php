<?php
$this->breadcrumbs=array(
	"Анонсы"=>array('list'),
	'Создание',
);

$this->menu=array(
	array('label'=>'Список','url'=>array('list')),
);
?>

<h1>Создание анонса</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'contents'=>$contents, 'times'=>$times)); ?>