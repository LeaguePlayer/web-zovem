	<?php echo $form->textFieldControlGroup($model,'title',array('class'=>'span8','maxlength'=>255)); ?>

	<?php echo $form->dropDownListControlGroup($model, 'status', Country::getStatusAliases(), array('class'=>'span8', 'displaySize'=>1)); ?>
