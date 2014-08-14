<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'event-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary(array($model, $contents)); ?>

    <?php if(Yii::app()->user->hasFlash('message')):?>
        <div class="alert alert-success">
            <?php echo Yii::app()->user->getFlash('message'); ?>
        </div>
    <?php endif; ?>
    
	<?php $tabs = array(); ?>
	<?php $tabs[] = array('label' => 'Основные данные', 'content' => $this->renderPartial('_rows', array('form'=>$form, 'model' => $model, 'contents' => $contents, 'times'=>$times), true), 'active' => true); ?>
	
	<?php $this->widget('bootstrap.widgets.TbTabs', array( 'tabs' => $tabs)); ?>

	<div class="form-actions">
		<?php echo TbHtml::submitButton('Сохранить', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)); ?>
		<? if (! $model->isNewRecord): ?>
        	<?php echo TbHtml::linkButton('Удалить', array('confirm'=>'Вы уверены, что хотите удалить анонс?', 'color' => TbHtml::BUTTON_COLOR_DANGER, 'url'=>'/admin/event/delete/id/'.$model->id)); ?>
        <? endif; ?>
        <?php echo TbHtml::linkButton('Отмена', array('url'=>'/admin/event/list')); ?>
	</div>

<?php $this->endWidget(); ?>
