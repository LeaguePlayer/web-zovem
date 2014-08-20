<?php
/**
 * @var $dataProvider CActiveDataProvider
 * @var $sections Section[]
 * @var $authors User[]
 * @var $this ArticleController
 * @var $tags Tag[]
 * @var $articleFilter Article
 */
?>


<? /** @var $filterForm CActiveForm */
$filterForm = $this->beginWidget('CActiveForm', array(
    'id' => 'article-filter',
    'htmlOptions' => array(
        'class' => 'filter'
    )
)) ?>

    <div class="left-bar">
        <ul>
            <? if ( count($sections) ): ?>
                <li role="dropdown-parent">
                    <?= $filterForm->dropDownList($articleFilter, 'section_id', CHtml::listData($sections, 'id', 'title'), array(
                        'empty' => '',
                        'placeholder' => $articleFilter->getAttributeLabel('section_id')
                    )) ?>
                </li>
            <? endif ?>

            <? if ( count($authors) ): ?>
                <li role="dropdown-parent">
                    <?= $filterForm->dropDownList($articleFilter, 'user_id', CHtml::listData($authors, 'id', 'fullName'), array(
                        'empty' => '',
                        'placeholder' => $articleFilter->getAttributeLabel('user_id')
                    )) ?>
                </li>
            <? endif ?>

            <li role="dropdown-parent">
                <a href="#" title="Выберите дату" role="dropdown-trigger">Сб 7 декабря</a>
                <div class="noshadow" style="width: 136px;"></div>
            </li>

            <? if ( count($tags) ): ?>
                <li role="dropdown-parent">
                    <a href="#" title="Выберите тему" role="dropdown-trigger">Тема</a>
                    <div class="noshadow" style="width: 136px;"></div>
                    <ul class="dropdown-list">
                        <? foreach ( $tags as $tag ): ?>
                            <li><a href="<?= $this->createUrl('/article/index', array('tag' => $tag->value)) ?>"><?= $tag->value ?></a></li>
                        <? endforeach ?>
                    </ul>
                </li>
            <? endif ?>
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

<? $this->endWidget() ?>



<div class="journal-list">
    <h1>Статьи</h1>
    <div class="authors">
        <h2>По авторам:</h2>
        <ul>
            <? foreach ( $authors as $author ): ?>
                <li><a href="#"><?= $author->getFullName() ?></a></li>
            <? endforeach ?>
        </ul>

        <h2><a href="/event/">Анонсы</a></h2>
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