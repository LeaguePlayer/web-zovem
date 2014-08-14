<?php

Yii::import('application.controllers.*');

class LkController extends FrontController
{

	public function renderFilter()
	{
		$this->renderPartial('//filters/lk');
	}

	public function actionIndex()
	{
        $this->title = Yii::app()->config->get('app.name');
		$this->render('index');
	}

	public function actionCreateEvent()
	{

	}


}