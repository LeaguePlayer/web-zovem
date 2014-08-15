<?php
$this->breadcrumbs=array(
	"Рубрики"=>array('list'),
	'Создание',
);

$this->menu=array(
	array('label'=>'Список','url'=>array('list')),
);
?>

<h1>Создание рубрики</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>