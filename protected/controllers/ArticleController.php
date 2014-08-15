<?php
/**
 * Class ArticleController
 */

class ArticleController extends FrontController
{
    public function actionIndex()
    {
        $criteria = new CDbCriteria;
        $criteria->with = 'section';
        $criteria->with = 'author';
        $criteria->with = 'tags';
        $criteria->order = 't.public_date';
        $articles = Article::model()->published()->findAll();

        $authors = User::model()->hasArticles()->findAll();
        $sections = Section::model()->hasArticles()->findAll();
        $tags = Tag::model()->hasArticles()->findAll();


        $dataProvider = new CArrayDataProvider($articles, array(
            'pagination' => array(
                'pageSize' => 20
            )
        ));

        $this->render('index', array(
            'dataProvider' => $dataProvider,
            'sections' => $sections,
            'authors' => $authors,
            'tags' => $tags,
        ));
    }


    public function actionView($id)
    {
        $article = Article::model()->with(array('author'))->published()->findByPk($id);
        if ( !$article ) {
            throw new CHttpException(404, 'Статья не найдена');
        }

        $authors = User::model()->hasArticles()->findAll();
        $sections = Section::model()->hasArticles()->findAll();
        $tags = Tag::model()->hasArticles()->findAll();

        $this->render('view', array(
            'article' => $article,
            'authors' => $authors,
            'sections' => $sections,
            'tags' => $tags
        ));
    }
}