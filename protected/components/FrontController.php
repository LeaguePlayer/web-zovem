<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class FrontController extends Controller
{
    public $layout='//layouts/main';
    public $menu=array();
    public $breadcrumbs=array();
    public $city = null;

    public function init() {
        parent::init();
        $this->title = Yii::app()->name;
    }


    public function renderFilter()
    {
        $this->renderPartial('//filters/main');
    }
    
    //Check home page
    public function is_home(){
        return $this->route == 'site/index';
    }

    protected function beforeAction($action){
        if(defined('YII_DEBUG') && YII_DEBUG){
            Yii::app()->assetManager->forceCopy = true;
        }
        return parent::beforeAction($action);
    }

    public function beforeRender($view)
    {
		$this->buildMenu();
        return parent::beforeRender($view);
    }

    public function buildMenu($currentNode = null)
    {
        $this->menu = Menu::model()->getMenuList();
    }

    public function actionError()
    {
        $this->layout = '//layouts/error';
        if($error=Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

}