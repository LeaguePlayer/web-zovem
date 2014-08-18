<?php

$cs = Yii::app()->clientScript;

$cs->registerCssFile($this->getAssetsUrl('application').'/css/normalize.css');
$cs->registerCssFile($this->getAssetsUrl('application').'/css/404.css');

?><!DOCTYPE html>
<!--[if IE 9]><html class="lt-ie10" lang="en" > <![endif]-->
<html class="no-js" lang="en" >

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--[if lt IE 9]>
    <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <![endif]-->
    <title>Главная</title>

</head>
<body>

<div class="page404">
    <div class="wrap">
        <div class="logo">
            <a href="/" title="Зовём"></a>
        </div>
        <div class="offers">
            <?= $content ?>
        </div>
        <div class="search">
            <form>
                <input type="search" placeholder="Найти на сайте">
            </form>
        </div>
    </div>
</div>

</body>
</html>
