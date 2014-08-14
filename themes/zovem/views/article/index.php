<?php
/**
 * @var $dataProvider CActiveDataProvider
 */
?>


<?php
    $this->widget('widgets.announce.AnnounceFavorites');
?>


<div class="filter">
    <div class="left-bar">
        <ul>
            <li role="dropdown-parent">
                <a href="#" title="Выберите раздел" role="dropdown-trigger">Раздел</a>
                <div class="noshadow" style="display: none; width: 110px;"></div>
                <ul class="dropdown-list" style="display: none;">
                    <li><a href="#">На покатушки</a></li>
                    <li><a href="#">На свадьбу</a></li>
                    <li><a href="#">На шоппинг</a></li>
                </ul>
            </li>
            <li role="dropdown-parent">
                <a href="#" title="Выберите автора" role="dropdown-trigger">Автор</a>
                <div class="noshadow" style="display: none; width: 136px;"></div>
                <ul class="dropdown-list" style="display: none;">
                    <li><a href="#">Анна Сидоренко</a></li>
                    <li><a href="#">Елена Анищева</a></li>
                    <li><a href="#">Дмитрий Эникеев</a></li>
                </ul>
            </li>
            <li role="dropdown-parent">
                <a href="#" title="Выберите дату" role="dropdown-trigger">Сб 7 декабря</a>
                <div class="noshadow" style="width: 136px;"></div>
                <ul class="dropdown-list">
                    <li><a href="#">Анна Сидоренко</a></li>
                    <li><a href="#">Елена Анищева</a></li>
                    <li><a href="#">Дмитрий Эникеев</a></li>
                </ul>
            </li>
            <li role="dropdown-parent">
                <a href="#" title="Выберите тему" role="dropdown-trigger">Тема</a>
                <div class="noshadow" style="width: 136px;"></div>
                <ul class="dropdown-list">
                    <li><a href="#">Анна Сидоренко</a></li>
                    <li><a href="#">Елена Анищева</a></li>
                    <li><a href="#">Дмитрий Эникеев</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="right-bar">
        <ul>
            <li><a href="#">Показывать сначала старые</a></li>
            <li>
                <label for="myonoffswitch">Во всех городах</label>
                <div class="onoffswitch">
                    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch">
                    <label class="onoffswitch-label" for="myonoffswitch">
                        <div class="onoffswitch-inner"></div>
                        <div class="onoffswitch-switch"></div>
                    </label>
                </div>
            </li>
        </ul>
    </div>
</div>



<div class="journal-list">
    <h1>Статьи</h1>
    <div class="authors">
        <h2>По авторам:</h2>
        <ul>
            <li><a href="#" title="Статьи и комментариии автора Петров Петр">Галина Тимченко</a></li>
            <li><a href="#" title="Статьи и комментариии автора Петров Петр">Александр Филимонов</a></li>
            <li><a href="#" title="Статьи и комментариии автора Петров Петр">Алексей Пономарев</a></li>
            <li><a href="#" title="Статьи и комментариии автора Петров Петр">Игорь Петрушев</a></li>
            <li><a href="#" title="Статьи и комментариии автора Петров Петр">Павел Борисов</a></li>
        </ul>
        <h2><a href="#">Анонсы</a></h2>
    </div>

    <? $this->widget('zii.widgets.CListView', array(
        'dataProvider' => $dataProvider,
        'itemView' => '_item'
    )) ?>

    <div class="content-items">
    </div>
</div>