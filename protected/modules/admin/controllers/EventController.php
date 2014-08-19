<?php

class EventController extends AdminController
{

	private function createMap($geolocate = true)
	{

        $gMap = new EGMap();
		$gMap->zoom = 16;
		$gMap->setJsName('map');
		$gMap->setCenter('55.7522200', '37.6155600');
		$gMap->appendMapTo('#map');
		$gMap->width = '100%';
		$gMap->addEvent(new EGMapEvent('click','addMarker', false));
		$gMap->renderMap();

		if ($geolocate) {
			//Автоподставление при геолокации
			Yii::app()->clientScript->registerScript('geolocation', "
				$(document).ready(function() {
					if (navigator.geolocation)
	    				navigator.geolocation.getCurrentPosition(fillLocation);
	    			function fillLocation(position) {
	    				var coords = new google.maps.LatLng(
							position.coords.latitude, position.coords.longitude
	    				);
						geocoder = new google.maps.Geocoder();
						geocoder.geocode({latLng: coords}, 
							function(results, status) {
								if (status == google.maps.GeocoderStatus.OK) {
									for(var i=0; i<results[0].address_components.length;i++) {
					                    if ($.inArray('country', results[0].address_components[i].types) != -1) {
					                        var country = results[0].address_components[i].long_name;
											$.post('/admin/country/countryExists', { title: country }, function(data) {
	                                            if (data == 'true') {
	                                                for (var j=0;j<$('#Contents_country_id option').length;j++) {
	                                                    if ($('#Contents_country_id option:eq('+j+')').text() == country) {
	                                                        $('#Contents_country_id').val($('#Contents_country_id option:eq('+j+')').val());
															$.post('/admin/event/dynamiccities', $('#Contents_city_id').parents('form').serialize(), function(html){
																$('#Contents_city_id').html(html);
																map.setCenter(coords);
																placeMarker(coords);
																for(var k=0; k<results[0].address_components.length;k++) {
												                    if ($.inArray('locality', results[0].address_components[k].types) != -1) {
												                        var city = results[0].address_components[k].long_name;
												                        $.post('/admin/city/cityExists', { title: city }, function(data) {
								                                            if (data == 'true') {
								                                                for (var l=0;l<$('#Contents_city_id option').length;l++) {
								                                                    if ($('#Contents_city_id option:eq('+l+')').text() == city) {
								                                                        $('#Contents_city_id').val($('#Contents_city_id option:eq('+l+')').val());
								                                                        $.post('/admin/event/dynamicmetros', $('#Contents_metro_id').parents('form').serialize(), function(html){
								                                                            $('#Contents_metro_id').html(html);
								                                                        });
																						break;
								                                                    }
								                                                }
								                                            }
								                                        });
												                        break;
												                    }
												                }
															});
	                                                        break;
	                                                    }
	                                                }
	                                            }
	                                        });
					                        break;
					                    }
					                }
								}
						});
	    			}
				});
			");
		}
		else {
			Yii::app()->clientScript->registerScript('geolocation', "
				$(window).load(function(){

				    if ($('#Contents_address').length && $('#Contents_address').val()) {
				        var crutch = setInterval(function(){
				                if (typeof map !== 'undefined') {
				                    geocode();  
				                    clearInterval(crutch);
				                }
				        }, 1);
				    }
				});
			");
		}
	}

	public function actionCreate()
    {
    	Yii::import('appext.EGMap.*');

        $model = new Event();
        $contents = new Contents();

        $contents->initDefaults();

        $this->createMap();

        $times = array();

        if(isset($_POST['Event']) && isset($_POST['Contents']))
        {

            $model->attributes = $_POST['Event'];
            $contents->attributes = $_POST['Contents'];

	        if (isset($_POST['Times'])) {
	        	foreach ($_POST['Times'] as $_time) {
	        		$time = new Time;
	        		$time->attributes = $_time;
	        		$times []= $time;
	        	}
	        }


            if( $model->validate() && $contents->validate() ) {
	        	if (! isset($_POST['Times'])) {
	        		$model->addError('contents_id', 'Необходимо добавить хотя бы одну дату проведения события.');
	        	}
	        	else {
	            	$model->save();

	            	$contents->event_id = $model->id;
	            	$contents->save();

	            	$model->saveAttributes(array('contents_id' => $contents->id));

		        	foreach ($times as $time) {
		        		$time->event_id = $model->id;
		        		$time->contents_id = $contents->id;
		        		$time->save();
		        	}

        			Yii::app()->user->setFlash('message', "Анонс был успешно добавлен.");
	                $this->redirect(array('/admin/event/update', 'id'=>$model->id));
	        	}
            }
        	if (! isset($_POST['Times']) && !$model->getError('contents_id')) {
        		$model->addError('contents_id', 'Необходимо добавить хотя бы одну дату проведения события.');
        	}
        }
        $this->render('create', array('model' => $model, 'contents' => $contents, 'times' => $times));
    }

	public function actionUpdate($id)
    {
    	Yii::import('appext.EGMap.*');

        $model = Event::model()->findByPk($id);
        $contents = $model->current_contents;

        $this->createMap(false);

        if (isset($_POST['Times']))
        	$times = array();
        else
	        $times = $model->getCurrentTimes();

        if(isset($_POST['Event']) && isset($_POST['Contents']))
        {

            $model->attributes = $_POST['Event'];
            $contents->attributes = $_POST['Contents'];

	        if (isset($_POST['Times'])) {
	        	foreach ($_POST['Times'] as $_time) {
	        		if (! isset($_time['_id'])) 
	        			$time = new Time;
	        		else 
	        			$time = Time::model()->findByPk($_time['_id']);
	        		$time->attributes = $_time;
	        		$times []= $time;
	        	}
	        }


            if( $model->validate() && $contents->validate() ) {
	        	if (! isset($_POST['Times'])) {
	        		$model->addError('contents_id', 'Необходимо добавить хотя бы одну дату проведения события.');
	        	}
	        	else {
	            	$model->save();

	            	$contents->event_id = $model->id;
	            	$contents->save();

	            	$model->saveAttributes(array('contents_id' => $contents->id));

		        	foreach ($times as $time) {
		        		$time->event_id = $model->id;
		        		$time->contents_id = $contents->id;
		        		$time->save();
		        	}

        			Yii::app()->user->setFlash('message', "Анонс был успешно сохранён.");
	                $this->redirect(array('/admin/event/update', 'id'=>$model->id));
	        	}
            }
        	if (! isset($_POST['Times']) && !$model->getError('contents_id')) {
        		$model->addError('contents_id', 'Необходимо добавить хотя бы одну дату проведения события.');
        	}
        }
        $this->render('update', array('model' => $model, 'contents' => $contents, 'times' => $times));
    }

    public function actionDynamiccities()
	{
		$model = 'Contents';
		if (!isset($_POST[$model]))
			$model = 'Organiser';


	    $data=City::model()->findAll('country_id=:country_id', 
	           array(':country_id'=>(int) $_POST[$model] ['country_id']));
	 
	    $data=CHtml::listData($data,'id','title');
	    echo CHtml::tag('option',
	                   array('value'=>''),'Выберите город',true);
	    foreach($data as $value=>$name)
	    {
	        echo CHtml::tag('option',
	                   array('value'=>$value),CHtml::encode($name),true);
	    }
	}

    public function actionDynamicmetros()
	{
		$model = 'Contents';
		if (!isset($_POST[$model]))
			$model = 'Organiser';

	    $data=Metro::model()->findAll('city_id=:city_id', 
	           array(':city_id'=>(int) $_POST[$model] ['city_id']));
	 
	    $data=CHtml::listData($data,'id','title');
	    echo CHtml::tag('option',
	                   array('value'=>''),'Выберите метро',true);
	    foreach($data as $value=>$name)
	    {
	        echo CHtml::tag('option',
	                   array('value'=>$value),CHtml::encode($name),true);
	    }
	}

	public function actionDeleteTime($id)
	{
		$time = Time::model()->findByPk($id);
		if (!is_null($time))
			$time->delete();
	}

	public function actionMassDelete()
	{
		$ids = $_POST['ids'];
		foreach ($ids as $id) {
			Event::model()->findByPk($id)->delete();
		}
        Yii::app()->user->setFlash('message', "Записи были успешно удалены.");
	}

	public function actionMassPublish()
	{
		$ids = $_POST['ids'];
		foreach ($ids as $id) {
			Event::model()->findByPk($id)->saveAttributes(array('status' => Event::STATUS_PUBLISHED));
		}
        Yii::app()->user->setFlash('message', "Записи были успешно опубликованы.");
	}

	public function actionList()
	{
		$model = Event::model();

		$model->unsetAttributes();
    	$model->status = Event::STATUS_PUBLISHED;

        if($showRemoved)
            $model->removed();
        
        if(isset($_GET['Event']))
            $model->attributes = $_GET['Event'];

        $this->render('list',array(
            'model' => $model,
            'showRemoved' => $showRemoved,
        ));
	}

}
