<?
/**
 * @var $articles Article[]
 */
?>

<div class="articles-feed">
    <h2>Ещё на эту тему:</h2>
    <ul>
        <? foreach ( $articles as $article ): ?>
            <li>
                <a href="<?= $article->url ?>" title="Статья раздела Кино"><?= $article->title ?></a>
                <span class="date"><?= $article->section->title ?>, <?= SiteHelper::russianDate($article->public_date, false) ?></span>
            </li>
        <? endforeach ?>
    </ul>
</div>
