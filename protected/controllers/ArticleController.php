<?php
/**
 * Class ArticleController
 */

class ArticleController extends FrontController
{
    public function actionIndex()
    {
        $criteria = new CDbCriteria;



        $dataProvider = new CActiveDataProvider('Article', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20
            )
        ));

        $this->render('index', array(
            'dataProvider' => $dataProvider
        ));
    }
}