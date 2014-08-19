<?php

class EventController extends FrontController
{
	
	
	public function actionIndex($when = 'now')
	{
		$times = Time::model()
			->with(array(
				array('event'=>array(
					'condition' => 'event.status = '.Event::STATUS_PUBLISHED,
				)),
				'event.current_contents',
				'event.current_contents.section',
			))
			->ordered()
			->when($when)
			->findAll();

        $dataProvider = new CArrayDataProvider($times, array(
            'pagination' => array(
                'pageSize' => 20
            )
        ));

        $this->render('index', array(
            'dataProvider' => $dataProvider,
            'when' => $when,
        ));
	}

	public function actionView($time_id)
	{
		$time = Time::model()->with(array(
			'event'=>array(
				'condition' => 'event.status = '.Event::STATUS_PUBLISHED,
			),
			'event.current_contents',
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

	public function actionAddToFavorites($time_id)
	{
		$time = Time::model()->findByPk($time_id);
		if ($time) {
			if (Yii::app()->user->isGuest) {
				Yii::app()->session['Favorites_'.$time_id] = true;
			}
			else {
				$favorite = new Favorite();
				$favorite->time_id = $time_id;
				$favorite->user_id = Yii::app()->user->id;
				$favorite->save();
			}
		}
	}


}
