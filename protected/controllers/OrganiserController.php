<?php

class OrganiserController extends FrontController
{

	public function actionView($id)
	{
		$organiser = Organiser::model()->with(array(
			'user' => array(
				'condition' => 'user.status = '.User::STATUS_ACTIVE,
			),
			'user.articles',
		))->findByPk($id);

        if ( !$organiser ) {
            throw new CHttpException(404, 'Устроитель не найден');
        }

        $this->render('view', array(
            'organiser' => $organiser,
            'articles' => $organiser->user->articles,
        ));
	}


	
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Organiser');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
}
