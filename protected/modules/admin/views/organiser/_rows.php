	
	<div class='control-group'>
	<?php echo CHtml::activeLabelEx($model, 'user_id'); ?>
	<?php
		$this->widget('yiiwheels.widgets.select2.WhSelect2', array(
			'asDropDownList' => true,
			'model'=>$model,
	   		'attribute'=>'user_id',
	   		'data'=>$model->isNewRecord ? User::getListNonOrganisers() : User::getListNonOrganisers($model->user_id),
			'pluginOptions'=>array(
			),
   		));
	?>
	</div>

	<?php echo $form->textFieldControlGroup($model,'title',array('class'=>'span8','maxlength'=>255)); ?>

	<div class='control-group'>
		<?php echo CHtml::activeLabelEx($model, 'img_image'); ?>
		<?php echo $form->fileField($model,'img_image', array('class'=>'span3')); ?>
		<div class='img_preview'>
			<?php if ( !empty($model->img_image) ) echo TbHtml::image( $model->imgBehaviorImage->getImageUrl('small') ) ; ?>
			<span class='deletePhoto btn btn-danger btn-mini' data-modelname='Organiser' data-attributename='Image' <?php if(empty($model->img_image)) echo "style='display:none;'"; ?>><i class='icon-remove icon-white'></i></span>
		</div>
		<?php echo $form->error($model, 'img_image'); ?>
	</div>

	<div class='control-group'>
	<?php echo CHtml::activeLabelEx($model, 'text'); ?>
	<? $this->widget('appext.redactor.ImperaviRedactorWidget', 
		array( 'model' => $model, 'attribute' => 'text', 'options' => array(
			'minHeight' => '300', 
		) )); ?>
	</div>

	<?php echo $form->textFieldControlGroup($model,'web',array('class'=>'span8','maxlength'=>255)); ?>

	<?php echo $form->dropDownListControlGroup($model, 'country_id', Country::getTitles(), array('class'=>'span8', 'displaySize'=>1, 'empty'=>'Выберите страну', 
		'ajax' => array(
			'type'=>'POST', 
			'url'=>'/admin/event/dynamiccities', 
			'update'=>'#'.CHtml::activeId($model,'city_id'), 
		)
	)); ?>
	<?php echo $form->dropDownListControlGroup($model, 'city_id', empty($model->country_id) ? 
                        array (  ) : CHtml::listData( City::model()->findAll(
                        array(
                            'condition' => 'country_id=:country_id', 
                            'params'=>array(':country_id' => $model->country_id)
                        )), 'id', 'title'), array('class'=>'span8', 'displaySize'=>1, 'empty'=>'Сначала выберите страну',
                        'ajax' => array(
							'type'=>'POST', 
							'url'=>'/admin/event/dynamicmetros', 
							'update'=>'#'.CHtml::activeId($model,'metro_id'), 
						))
                      ); ?>
	<?php echo $form->dropDownListControlGroup($model, 'metro_id', empty($model->city_id) ? 
                        array (  ) : CHtml::listData( Metro::model()->findAll(
                        array(
                            'condition' => 'city_id=:city_id', 
                            'params'=>array(':city_id' => $model->city_id)
                        )), 'id', 'title'), array('class'=>'span8', 'displaySize'=>1, 'empty'=>'Сначала выберите город'
                      )); ?>
	<?php echo $form->textFieldControlGroup($model,'address',array('class'=>'span8')); ?>
