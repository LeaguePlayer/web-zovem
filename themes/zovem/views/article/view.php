<?php
/**
 * @var $article Article
 * @var $sections Section[]
 * @var $authors User[]
 * @var $tags Tag[]
 */
?>

<?php
$this->widget('widgets.event.EventFavorites');
?>

<div class="filter">
    <div class="left-bar">
        <ul>
            <li><a href="#" title="Выберите раздел">Раздел</a></li>
            <li><a href="#" title="Выберите автора">Автор</a></li>
            <li><a href="#" title="Выберите дату">Сб 7 декабря</a></li>
            <li><a href="#" title="Выберите тему">Тема</a></li>
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

<div class="journal-article">
    <article>
        <div class="article">
            <h1><a href="<?= $article->section->url ?>"><?= $article->section->title ?></a> — <?= $article->title ?></h1>
            <p class="author">
                <a href="#" title="Статьи и комментариии автора Петров Петр"><?= $article->author->fullName ?></a>
                <span class="date"><?= SiteHelper::russianDate($article->public_date, false, true) ?></span>
            </p>
            <div class="content">
                <?= $article->content ?>
            </div>
            <p class="tags">
<!--                --><?// var_dump(count($article->tags)); die(); ?>
                <? foreach ( $article->tags as $tag ): ?>
                    <a href="#"><?= $tag->value ?></a>
                <? endforeach ?>
            </p>
            <div class="sharing">
                <div class="social">
                    <a href="#"><img src="./images/vk.png"></a>
                    <a href="#"><img src="./images/fb.png"></a>
                    <a href="#"><img src="./images/tw.png"></a>
                    <a href="#"><img src="./images/ok.png"></a>
                </div>
                <div class="lcomments">
                    <a href="#" class="comments" title="Комментарии"><?= $article->comments_count ?></a>
                    <a href="#" class="likes liked" title="Нравится">120</a>
                </div>
            </div>


            <? $this->widget('widgets.comment.CommentsWidget', array(
                'type' => ArticleComment::TYPE_OF_COMMENT,
                'material_id' => $article->id
            )) ?>

        </div>
    </article>
    <div class="right-bar">
        <h2>Ещё на эту тему:</h2>
        <ul>
            <li>
                <a href="#" title="Статья раздела Кино">Кинодень Японии: современное кино — Такэси Китано и Такаси Миикэ</a>
                <span class="date">Мероприятия, 24 августа</span>
            </li>
            <li>
                <a href="#" title="Статья раздела Кино">Кинодень Японии: современное кино — Такэси Китано и Такаси Миикэ</a>
                <span class="date">Мероприятия, 24 августа</span>
            </li>
            <li>
                <a href="#" title="Статья раздела Кино">Кинодень Японии: современное кино — Такэси Китано и Такаси Миикэ</a>
                <span class="date">Мероприятия, 24 августа</span>
            </li>
            <li>
                <a href="#" title="Статья раздела Кино">Кинодень Японии: современное кино — Такэси Китано и Такаси Миикэ</a>
                <span class="date">Мероприятия, 24 августа</span>
            </li>
        </ul>
    </div>
</div>