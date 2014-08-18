<?php

class EventController extends FrontController
{
	
	
	public function actionIndex()
	{
		$times = Time::model()->with(array(
			'event', 
			array('event.current_contents'=>array(
				'condition' => 'event.status = '.Event::STATUS_PUBLISHED,
			)),
			'event.current_contents.section',
		))->findAll();

        $dataProvider = new CArrayDataProvider($times, array(
            'pagination' => array(
                'pageSize' => 20
            )
        ));

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
	}

	public function actionView($time_id)
	{
		$time = Time::model()->with(array(
			'event', 
			array('event.current_contents'=>array(
				'condition' => 'event.status = '.Event::STATUS_PUBLISHED,
			)),
			'event.current_contents.section',
		))->findByPk($time_id);

        if ( !$time ) {
            throw new CHttpException(404, 'Событие не найдено');
        }

        $this->render('view', array(
            'time' => $time,
            'event' => $time->event,
        ));
	}


}
