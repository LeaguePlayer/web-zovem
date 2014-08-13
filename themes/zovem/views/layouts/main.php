<?php

	$cs = Yii::app()->clientScript;

	$cs->registerCssFile($this->getAssetsUrl('application').'/css/normalize.css');
	$cs->registerCssFile($this->getAssetsUrl('application').'/css/main.css');

	$cs->registerScriptFile($this->getAssetsUrl('application').'/js/jquery-1.11.0.min.js');
	$cs->registerScriptFile($this->getAssetsUrl('application').'/js/jquery.sudoSlider.min.js', CClientScript::POS_END);
	$cs->registerScriptFile($this->getAssetsUrl('application').'/js/ui/minified/jquery-ui.min.js', CClientScript::POS_END);
	$cs->registerScriptFile($this->getAssetsUrl('application').'/js/jquery.timepicker.min.js', CClientScript::POS_END);
	$cs->registerScriptFile($this->getAssetsUrl('application').'/js/main.js', CClientScript::POS_END);

	$cs->registerScriptFile('http://api-maps.yandex.ru/1.1/index.xml?key=AEAea1MBAAAAyd1ldgMAHHvA10B6zZQqEfjYbZ6Mg2mBIjkAAAAAAAAAAABlFElqSbqpo8bwi1IXkRrPYTpSWA==', CClientScript::POS_END);


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

  <div class="wrap">
    <div class="top-banners">
      <a href="#" target="_blank"><img src="/media/images/banner1.png"></a>
      <a href="#" target="_blank"><img src="/media/images/banner2.png"></a>
      <a href="#" target="_blank"><img src="/media/images/banner3.png"></a>
      <a href="#" target="_blank"><img src="/media/images/banner4.png"></a>
    </div>

    <header>
      <div class="header">
        <div class="logo">
          <a href="#" title="Зовём"></a>
        </div>
        <div class="city" role="dropdown-parent">
          <a href="#" role="dropdown-trigger">Москва</a>
          <div class="noshadow"></div>
          <ul class="dropdown-list">
            <li><a href="#">Санкт-Петербург</a></li>
          </ul>
        </div>
        <div class="menu">
          <nav>
            <ul>
              <li class="current"><a href="#" title="Главная">Главная</a></li>
              <li><a href="#" title="Зовём карта">Зовем карта</a></li>
              <li><a href="#" title="Статьи">Статьи</a></li>
              <li><a href="#" title="Места и люди">Места и люди</a></li>
              <li><a href="#" title="О проекте">О проекте</a></li>
            </ul>
          </nav>
        </div>
      </div>
    </header>

    <div class="top-filter">
      <div class="new-action">
        <a href="#" title="Создать мероприятие">мероприятие</a>
      </div>
      <div class="filter-box">
        <div class="tag-search" role="dropdown-parent">
          <a href="#" title="Поиск по темам" role="dropdown-trigger">
            <span class="icon"></span> Поиск по темам
          </a>
          <div class="noshadow"></div>
          <ul class="dropdown-list">
            <li><a href="#">Альпинизм</a></li>
            <li><a href="#">Концерты</a></li>
            <li><a href="#">Арт-фестивали</a></li>
            <li><a href="#">Кинопремьеры</a></li>
            <li><a href="#">Купить слона</a></li>
          </ul>
        </div>
        <div class="right">
          <div class="dates" role="dropdown-parent">
            <a href="#" title="Выберите дату" role="dropdown-trigger">Сегодня, сб 7 декабря</a>
            <div class="noshadow"></div>
            <ul class="dropdown-list">
              <li><a href="#">Сегодня, сб 7 декабря</a></li>
              <li><a href="#">Завтра, вс 8 декабря</a></li>
              <li><a href="#">На следующей неделе</a></li>
            </ul>
          </div>
          <div class="action-types" role="dropdown-parent">
            <a href="#" title="Выберите рубрику" role="dropdown-trigger">
              По разделам
            </a>
            <div class="noshadow"></div>
            <ul class="dropdown-list">
              <li><a href="#">Киносеансы</a></li>
              <li><a href="#">Ярмарки</a></li>
              <li><a href="#">Концерты</a></li>
              <li><a href="#">Путешествия</a></li>
            </ul>
          </div>
        </div>
      </div>

      <? $this->beginWidget('application.modules.hybridauth.components.ProfileWidget',array(
          'action' => $authAction ? $authAction : 'signin',
        ));
      $this->endWidget(); ?>

    </div>

    <?= $content; ?>

    <footer>
      <div class="footer">
        <div class="disclaimer">
          Внимание: информация, представленная на сайте zovem.ru, взята из открытых источников. За достоверность, полноту и актуальность ее, а также работоспособность сторонних сайтов проект Зовем.Ру ответственности не несет! Вы можете уточнить информацию у организаторов мероприятий по указанным контактным данным и ссылкам.
        </div>
        <div class="bottom">
          <div class="copyright">
            © 2007-2013 <a href="http://zovem.ru">zovem.ru</a>
          </div>
          <div class="search">
            <form>
              <input type="search" placeholder="Найти на сайте">
            </form>
          </div>
          <div class="counter">
            <img src="/media/images/counter.png">
          </div>
          <div class="social">
            <a href="#" class="vk" target="_blank"></a>
            <a href="#" class="lj" target="_blank"></a>
          </div>
        </div>
      </div>
    </footer>
   
  </div>
     
</body>
</html>
