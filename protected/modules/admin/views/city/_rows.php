	<?php echo $form->dropDownListControlGroup($model, 'country_id', Country::getTitles(), array('class'=>'span8', 'displaySize'=>1, 'empty'=>'Выберите страну')); ?>
	
	<?php echo $form->textFieldControlGroup($model,'title',array('class'=>'span8','maxlength'=>255)); ?>

	<?php echo $form->dropDownListControlGroup($model, 'status', City::getStatusAliases(), array('class'=>'span8', 'displaySize'=>1)); ?>
