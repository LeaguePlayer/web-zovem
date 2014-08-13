
    <div class="lk new-smth">

    	<h1>Регистрация</h1>
        <div class="form">
		<?php 
			$form=$this->beginWidget('CActiveForm', array(
				'id'=>'create-user-form',
				'enableAjaxValidation'=>false,
			)); 
		?>
      	    <div class="form-fields">
      	    
      	    <?php echo $form->errorSummary(array($user, $profile)); ?>

              <p><input type="hidden" name="name" class="name"></p>
              <p><?php echo $form->textField($user,'email', array('placeholder' => $user->getAttributeLabel('email'), 'class' => 'textinput')); ?></p>
              <p><?php echo $form->passwordField($user,'password', array('placeholder' => $user->getAttributeLabel('password'), 'class' => 'textinput')); ?></p>
              <p><?php echo $form->passwordField($user,'verifyPassword', array('placeholder' => $user->getAttributeLabel('verifyPassword'), 'class' => 'textinput')); ?></p>
              <p><?php echo $form->textField($profile,'first_name', array('placeholder' => $profile->getAttributeLabel('first_name'), 'class' => 'textinput')); ?></p>
              <p><?php echo $form->textField($profile,'last_name', array('placeholder' => $profile->getAttributeLabel('last_name'), 'class' => 'textinput')); ?></p>
              <p><?php echo $form->hiddenField($profile,'img_photo', array('placeholder' => $profile->getAttributeLabel('img_photo'), 'class' => 'textinput')); ?></p>
             
              <div class="bottom">
                <button type="submit">Зарегистрироваться</button>
              </div>
            </div>
		<?php $this->endWidget(); ?>
        </div>
      </div>