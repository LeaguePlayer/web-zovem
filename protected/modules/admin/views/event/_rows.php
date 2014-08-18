	<script type="text/javascript">
		window.times = <?= CJSON::encode(SiteHelper::timesToTimes($times));?>;
	</script>


	<div class='control-group'>
	<?php echo CHtml::activeLabelEx($model, 'user_id'); ?>
	<?php
		$this->widget('yiiwheels.widgets.select2.WhSelect2', array(
			'asDropDownList' => true,
			'model'=>$model,
	   		'attribute'=>'user_id',
	   		'data'=>User::getListUsers(),
			'pluginOptions'=>array(
			),
   		));
	?>
	</div>

<h3>Шаблон</h3>
	<?php echo $form->dropDownListControlGroup($model, 'template_id', Template::getTitles(), array('class'=>'span8', 'displaySize'=>1, 'empty'=>'Выберите шаблон')); ?>
	


<h3>Описание анонса</h3>
	<?php echo $form->dropDownListControlGroup($contents, 'section_id', Section::getTitles(), array('class'=>'span8', 'displaySize'=>1, 'empty'=>'Выберите рубрику')); ?>

	<?php echo $form->textFieldControlGroup($contents,'title',array('class'=>'span8')); ?>
	
	<div class='control-group'>
	<?php echo CHtml::activeLabelEx($contents, 'wswg_body'); ?>
	<? $this->widget('appext.redactor.ImperaviRedactorWidget', 
		array( 'model' => $contents, 'attribute' => 'wswg_body', 'options' => array(
			'minHeight' => '500', 
		) )); ?>
	</div>

	<?php echo $form->checkBoxControlGroup($contents,'is_free'); ?>

	<?php echo $form->textFieldControlGroup($contents,'price',array('class'=>'span8')); ?>

	<?php echo $form->checkBoxControlGroup($contents,'type'); ?>
	<?php echo $form->checkBoxControlGroup($contents,'is_federal'); ?>

	<div class='control-group'>
		<?php echo CHtml::activeLabelEx($contents, 'img_photo'); ?>
		<?php echo $form->fileField($contents,'img_photo', array('class'=>'span3')); ?>
		<div class='img_preview'>
			<?php if ( !empty($contents->img_photo) ) echo TbHtml::imageRounded( $contents->imgBehaviorPhoto->getImageUrl('small') ) ; ?>
			<span class='deletePhoto btn btn-danger btn-mini' data-modelname='Contents' data-attributename='Photo' <?php if(empty($contents->img_photo)) echo "style='display:none;'"; ?>><i class='icon-remove icon-white'></i></span>
		</div>
		<?php echo $form->error($contents, 'img_photo'); ?>
	</div>

	<?php echo $form->textAreaControlGroup($contents,'terms',array('rows'=>10, 'class'=>'span12')); ?>
	
	<?php echo $contents->tagsWidget(array('class'=>'span12', 'style' => 'width:100%')) ?>

	

<h3>Место проведения</h3>
	
	<?php echo $form->dropDownListControlGroup($contents, 'country_id', Country::getTitles(), array('class'=>'span8', 'displaySize'=>1, 'empty'=>'Выберите страну', 
		'ajax' => array(
			'type'=>'POST', 
			'url'=>'/admin/event/dynamiccities', 
			'update'=>'#'.CHtml::activeId($contents,'city_id'), 
		)
	)); ?>
	<?php echo $form->dropDownListControlGroup($contents, 'city_id', empty($contents->country_id) ? 
                        array (  ) : CHtml::listData( City::model()->findAll(
                        array(
                            'condition' => 'country_id=:country_id', 
                            'params'=>array(':country_id' => $contents->country_id)
                        )), 'id', 'title'), array('class'=>'span8', 'displaySize'=>1, 'empty'=>'Сначала выберите страну',
                        'ajax' => array(
							'type'=>'POST', 
							'url'=>'/admin/event/dynamicmetros', 
							'update'=>'#'.CHtml::activeId($contents,'metro_id'), 
						))
                      ); ?>
	<?php echo $form->dropDownListControlGroup($contents, 'metro_id', empty($contents->city_id) ? 
                        array (  ) : CHtml::listData( Metro::model()->findAll(
                        array(
                            'condition' => 'city_id=:city_id', 
                            'params'=>array(':city_id' => $contents->city_id)
                        )), 'id', 'title'), array('class'=>'span8', 'displaySize'=>1, 'empty'=>'Сначала выберите город'
                      )); ?>
	<?php echo $form->textFieldControlGroup($contents,'address',array('class'=>'span8')); ?>


	<div class="row">
		<div id="map">
			
		</div>
	</div>

	<?php echo $form->textAreaControlGroup($contents,'way',array('rows'=>10, 'class'=>'span12')); ?>
	


<h3>Дата и место проведения</h3>



	<div class='control-group' style="margin: 0 0 20px 0">
		<label for="timesType">Тип мероприятия</label>
		<div class="controls">
			<div class="span4">
			<?php echo CHtml::dropDownList('timesType', $select, 
              array('single' => 'Разовое', 'periodic' => 'Периодическое', 'longer'=>'Длительное'), array('class'=>'span11')); ?>
        	</div>
        	<button class="btn" id="timesModalTrigger">Добавить в календарь</button>
        	<button class="pull-right btn btn-danger">Очистить календарь</button>
        </div>
	</div>

	<div id="timesModal" class="modal hide fade" tabindex="-1" role="dialog">

	<?php $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
        'name' => 'datepickertest',
        'pluginOptions' => array(
            'format' => 'mm/dd/yyyy'
        )
    ));
	?>

	<?php $this->widget(
	    'yiiwheels.widgets.timepicker.WhTimePicker',
	    array(
	        'name' => 'timepickertest',
	        'pluginOptions' => array(
	            'format' => 'dropdown'
	        )
	    )
	);?>
	</div>

	<div class='control-group'>
	<?php $this->widget('ext.fullcalendar.EFullCalendarHeart', array(
	    'options'=>array(
	        'header'=>array(
	            'left'=>'prevYear,prev,next,nextYear,today',
	            'center'=>'title',
	            'right'=>'month,agendaWeek,agendaDay',
	        ), 
	        'lang' => 'ru',
	        'selectable' => true,
	        'selectHelper' => true,
	    ),
	    'htmlOptions' => array('id' => 'timesCalendar'),
	   ));
	?>
	</div>



	

<h3>Информация об организаторе</h3>
	
	<div class='control-group'>
		<?php echo CHtml::activeLabelEx($contents, 'img_org'); ?>
		<?php echo $form->fileField($contents,'img_org', array('class'=>'span3')); ?>
		<div class='img_preview'>
			<?php if ( !empty($contents->img_org) ) echo TbHtml::imageRounded( $contents->imgBehaviorOrg->getImageUrl('small') ) ; ?>
			<span class='deletePhoto btn btn-danger btn-mini' data-modelname='Contents' data-attributename='Org' <?php if(empty($contents->img_org)) echo "style='display:none;'"; ?>><i class='icon-remove icon-white'></i></span>
		</div>
		<?php echo $form->error($contents, 'img_org'); ?>
	</div>
	
	<?php echo $form->textFieldControlGroup($contents,'org',array('class'=>'span8')); ?>

	<?php echo $form->textFieldControlGroup($contents,'web',array('class'=>'span8')); ?>

	<?php echo $form->textFieldControlGroup($contents,'phone',array('class'=>'span8')); ?>

	<?php echo $form->emailFieldControlGroup($contents,'email',array('class'=>'span8')); ?>




<h3>Дополнительно</h3>

	<?php echo $form->textAreaControlGroup($contents,'comment',array('rows'=>10, 'class'=>'span12')); ?>

	<?php echo $form->textAreaControlGroup($contents,'label',array('rows'=>10, 'class'=>'span12')); ?>



	<?php echo $form->dropDownListControlGroup($model, 'status', Event::getStatus(), array('class'=>'span8', 'displaySize'=>1)); ?>

