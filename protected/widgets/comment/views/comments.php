<?php
/**
 * @var $comments Comment[]
 * @var $model CommentForm
 * @var $this CController
 * @var $type string
 * @var $user User
 */
?>

<div class="comments">

    <? if ( count($comments) ): ?>
        <h2>Комментарии:</h2>
        <div class="items">
            <?php foreach ( $comments as $comment ): ?>
                <div class="item" data-id="<?= $comment->id ?>" data-comment-type="<?= $comment->type ?>" data-material-id="<?= $comment->material_id ?>">
                    <p class="author">
                        <? $userName = $comment->user === null ? 'Гость' : $comment->user->fullName ?>
                        <a href="#" title="Статьи и комментариии автора <?= $userName ?>"><?= $userName ?></a>
                        <span class="date"><?= SiteHelper::russianDate($comment->date, false, true) ?></span>

                        <? if ( Yii::app()->user->checkAccess('comment.delete') || Yii::app()->user->id === $comment->user_id ): ?>
                            <a class="remove-comment" title="Удалить комментарий" href="#">x</a>
                        <? endif ?>
                    </p>
                    <div class="content">
                        <?= $comment->text ?>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <? endif ?>


    <? /** @var $form CActiveForm */ ?>
    <? $form = $this->beginWidget('CActiveForm', array(
        'id' => 'comment-form'
    )) ?>
        <h3>Написать комментарий:</h3>

        <?= $form->errorSummary($model) ?>

        <? if ( Yii::app()->user->hasFlash('comment-form') ): ?>
            <p class="alert"><?= Yii::app()->user->getFlash('comment-form') ?></p>
        <? endif ?>

        <?= $form->textArea($model, 'text') ?>
        <?= $form->error($model, 'text') ?>

        <div class="form-bottom">
            <input type="submit" class="submit">
        </div>
    <? $this->endWidget() ?>
</div>