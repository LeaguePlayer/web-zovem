<?php
/**
 * @var $this ArticleController
 * @var $model Article
 */

$this->breadcrumbs=array(
    "Структура сайта"=>array('/admin/structure/list'),
    "Статьи"=>array('/admin/article/list'),
    'Создание',
);
?>

<h3>Добавление статьи</h3>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>