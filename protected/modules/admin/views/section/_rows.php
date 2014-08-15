	<?php echo $form->textFieldControlGroup($model,'title',array('class'=>'span8','maxlength'=>255)); ?>

	<div class='control-group'>
		<?php echo CHtml::activeLabelEx($model, 'img_icon'); ?>
		<?php echo $form->fileField($model,'img_icon', array('class'=>'span3')); ?>
		<div class='img_preview'>
			<?php if ( !empty($model->img_icon) ) echo TbHtml::imageRounded( $model->imgBehaviorIcon->getImageUrl('small') ) ; ?>
			<span class='deletePhoto btn btn-danger btn-mini' data-modelname='Section' data-attributename='Icon' <?php if(empty($model->img_icon)) echo "style='display:none;'"; ?>><i class='icon-remove icon-white'></i></span>
		</div>
		<?php echo $form->error($model, 'img_icon'); ?>
	</div>

