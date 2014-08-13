<?php

class CityController extends AdminController
{
	
    public function actionCityExists()
	{
	   	$city = City::model()->find(array(
	        'condition'=>'title=:title', 
	        'params'=>array(':title'=>$_POST['title'])
	    ));
	    if (is_null($city)) {
	    	echo 'false';
	    }
	    else {
	    	echo 'true';
	    }
	}


}
