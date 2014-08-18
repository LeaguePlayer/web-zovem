<?php
$this->pageTitle=Yii::app()->name . ' - Error';
?>

<h1>Страница не найдена</h1>
<h2>Попробуйте:</h2>
<p><a href="/" title="Зовём - главная">Перейти на главную</a></p>
<p><a href="#" title="Куда пойти на этих выходных?">Пойти куда-нибудь на этих выходных</a></p>
<p><a href="#" title="Где встретиться с друзьями?">Встретиться с друзьями</a></p>

<? if ( YII_DEBUG ): ?>
    <h2>Error <?= $code; ?></h2>
    <div class="error">
        <?= CHtml::encode($message); ?>
    </div>
<? endif ?>