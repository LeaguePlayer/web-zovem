<?php

class SiteController extends FrontController
{

	/**
	 * Declares class-based actions.
	 */

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
        $this->title = Yii::app()->config->get('app.name');
		$this->render('index', array('sections' => Section::getIndexSections($this->city)));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
}