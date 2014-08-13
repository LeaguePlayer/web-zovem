<?php

class CountryController extends AdminController
{
	
    public function actionCountryExists()
	{
	   	$country = Country::model()->find(array(
	        'condition'=>'title=:title', 
	        'params'=>array(':title'=>$_POST['title'])
	    ));
	    if (is_null($country)) {
	    	echo 'false';
	    }
	    else {
	    	echo 'true';
	    }
	}
	
}
