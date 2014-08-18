<?php
/**
 * @var $dataProvider CActiveDataProvider
 * @var $sections Section[]
 * @var $authors User[]
 * @var $this ArticleController
 * @var $tags Tag[]
 */
?>


<?php
    $this->widget('widgets.event.EventFavorites');
?>


<div class="filter">
    <div class="left-bar">
        <ul>
            <li role="dropdown-parent">
                <a href="#" title="Выберите раздел" role="dropdown-trigger">Раздел</a>
                <div class="noshadow" style="display: none; width: 110px;"></div>
                <ul class="dropdown-list" style="display: none;">
                    <? foreach ( $sections as $section ): ?>
                        <li><a href="#"><?= $section->title ?></a></li>
                    <? endforeach ?>
                </ul>
            </li>
            <li role="dropdown-parent">
                <a href="#" title="Выберите автора" role="dropdown-trigger">Автор</a>
                <div class="noshadow" style="display: none; width: 136px;"></div>
                <ul class="dropdown-list" style="display: none;">
                    <? foreach ( $authors as $author ): ?>
                        <li><a href="#"><?= $author->fullName ?></a></li>
                    <? endforeach ?>
                </ul>
            </li>
            <li role="dropdown-parent">
                <a href="#" title="Выберите дату" role="dropdown-trigger">Сб 7 декабря</a>
                <div class="noshadow" style="width: 136px;"></div>
            </li>
            <li role="dropdown-parent">
                <a href="#" title="Выберите тему" role="dropdown-trigger">Тема</a>
                <div class="noshadow" style="width: 136px;"></div>
                <ul class="dropdown-list">
                    <? foreach ( $tags as $tag ): ?>
                        <li><a href="<?= $this->createUrl('/article/index', array('tag' => $tag->value)) ?>"><?= $tag->value ?></a></li>
                    <? endforeach ?>
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
            <? foreach ( $authors as $author ): ?>
                <li><a href="#"><?= $author->getFullName() ?></a></li>
            <? endforeach ?>
        </ul>

        <h2><a href="#">Анонсы</a></h2>
    </div>

    <? $this->widget('zii.widgets.CListView', array(
        'dataProvider' => $dataProvider,
        'template' => '{items}{pager}',
        'itemView' => '_item',
        'pager' => array(
            'cssFile' => $this->getAssetsUrl() . '/css/pager.css',
        ),
        'htmlOptions' => array(
            'class' => 'content-items'
        )
    )) ?>
</div>