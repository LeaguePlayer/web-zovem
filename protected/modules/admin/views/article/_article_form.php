<?php
/**
 * @var $form TbActiveForm
 * @var $model Article
 * @var $cs CClientScript
 */
?>

<?php echo $form->textFieldControlGroup($model, 'title', array('class' => 'span12')) ?>

<div class='control-group'>
    <?php echo $form->labelEx($model, 'content'); ?>
    <? $this->widget('appext.redactor.ImperaviRedactorWidget', array(
        'model' => $model,
        'attribute' => 'content',
        'options' => array(
            'minHeight' => '500',
        )
    )); ?>
</div>

<?php echo $model->tagsWidget(array('class'=>'span12', 'style' => 'width:100%')) ?>

<?php echo $form->dropDownListControlGroup($model, 'status', News::getStatusAliases(), array('class'=>'span12', 'displaySize'=>1)); ?>
