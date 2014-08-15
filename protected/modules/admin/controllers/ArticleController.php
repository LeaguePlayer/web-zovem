<?php
/**
 * Class ArticleController
 *
 */
class ArticleController extends AdminController
{
    public function actionCreate()
    {
        $model = new Article();

        if ( isset($_POST['Article']) ) {
            $model->attributes = $_POST['Article'];
            if ( $model->save() ) {
                $this->redirect(array('/admin/article/list'));
            }
        }

        $this->render('create', array(
            'model' => $model
        ));
    }


    public function actionUpdate($id)
    {
        $model = $this->loadModel('Article', $id);

        if ( isset($_POST['Article']) ) {
            $model->attributes = $_POST['Article'];
            if ( $model->save() ) {
                $this->redirect(array('/admin/article/list'));
            }
        }

        $this->render('update', array(
            'model' => $model
        ));
    }
}