<?php
$this->breadcrumbs=array(
	"Устроители"=>array('list'),
	'Создание',
);

$this->menu=array(
	array('label'=>'Список','url'=>array('list')),
);
?>

<h1>Создание устроителя</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>