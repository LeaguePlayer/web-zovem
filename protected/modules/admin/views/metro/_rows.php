	<?php echo $form->dropDownListControlGroup($model, 'city_id', City::getTitles(), array('class'=>'span8', 'displaySize'=>1, 'empty'=>'Выберите город')); ?>

	<?php echo $form->textFieldControlGroup($model,'title',array('class'=>'span8','maxlength'=>255)); ?>

	<?php echo $form->dropDownListControlGroup($model, 'status', Metro::getStatusAliases(), array('class'=>'span8', 'displaySize'=>1)); ?>
