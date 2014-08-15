<?php
/**
 * @var $model Article
 */

$this->breadcrumbs=array(
    "Структура сайта"=>array('/admin/structure/list'),
    "Публикации"=>array('/admin/article/list'),
    'Редактирование',
);
?>

<h3>Редактирование публикации "<?php echo $model->title ?>"</h3>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>