<?php

class EventController extends FrontController
{
	
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel('Event', $id),
		));
	}

	
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Event');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
}
