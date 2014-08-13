<?php
class ProfileWidget extends CWidget {
 
	public $action;

	private $user;


	public function init()
    {
        $this->user = Yii::app()->user;
    }

    public function run() {
    	if ($this->user->isGuest) {
        	$this->render('profileLogin', array(
        		'action' => $this->action,
        	));
    	}
    	else {
    		$this->render('profile', array(
    			'user' => $this->user,
        	));
    	}
    }
 
}
?>