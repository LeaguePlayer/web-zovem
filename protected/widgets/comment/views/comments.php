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
    <h2>Комментарии:</h2>

    <div class="items">

        <?php foreach ( $comments as $comment ): ?>
            <div class="item">
                <p class="author">
                    <a href="#" title="Статьи и комментариии автора <?= $comment->user->fullName ?>"><?= $comment->user->fullName ?></a>
                    <span class="date"><?= SiteHelper::russianDate($comment->date, false, true) ?></span>
                </p>
                <div class="content">
                    <?= $comment->text ?>
                </div>
            </div>
        <?php endforeach ?>
    </div>


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