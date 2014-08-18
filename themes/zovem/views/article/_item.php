<?php
/**
 * @var $data Article
 */
?>

<div class="item">
    <h2><a href="<?= $data->getUrl() ?>" title="<?= $data->section->title ?>"><?= $data->title ?></a><img
            class="section_icon" src="<?= $data->section->icon ?>" alt="<?= $data->section->title ?>"/>
    </h2>
    <p class="preview">
        <?= $data->annotate ?>
        <span class="date"><?= SiteHelper::russianDate($data->public_date, false) ?></span>
    </p>
    <div class="misc">
        <p class="tags">
            <? foreach ( $data->tags as $tag ): ?>
                <a<? if ( $tag->value == $_GET['tag'] ) echo ' class="active"' ?> href="<?= $this->createUrl('/article/index', array('tag' => $tag->value)) ?>" title="<?= $tag->value ?>"><?= $tag->value ?></a>
            <? endforeach ?>
        </p>
        <p class="lcomments">
            <a href="#" class="comments" title="Комментарии"><?= $data->comments_count ?></a>
            <a href="#" class="likes liked" title="Нравится">0</a>
        </p>
    </div>
</div>