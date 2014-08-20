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

		$upcoming = Time::model()
			->with(array(
				'event'=>array(
					'condition' => 'event.status = '.Event::STATUS_PUBLISHED.' AND event.user_id = '.$organiser->user_id,
					'limit' => 1,
				),
				'event.current_contents',
				'event.current_contents.section',
			))
			->ordered()
			->upcoming()
			->limited(5)
			->findAll();

		$archived = Time::model()
			->with(array(
				'event'=>array(
					'condition' => '(event.status = '.Event::STATUS_PUBLISHED.' OR event.status = '.Event::STATUS_ARCHIVED.') AND event.user_id = '.$organiser->user_id,
					'limit' => 1,
				),
				'event.current_contents',
				'event.current_contents.section',
			))
			->ordered()
			->archived()
			->limited(5)
			->findAll();

        $this->render('view', array(
            'organiser' => $organiser,
            'articles' => $organiser->user->articles,
            'upcoming' => $upcoming,
            'archived' => $archived,
        ));
	}

	
	public function actionIndex()
	{
		$sections = Section::getOrganiserSections();

        $dataProvider = new CArrayDataProvider($sections, array(
            'pagination' => false,
        ));

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));

	}
}
