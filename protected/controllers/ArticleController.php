<?php
/**
 * Class ArticleController
 */

class ArticleController extends FrontController
{
    public function actionIndex($tag = null)
    {
        $criteria = new CDbCriteria;
        $criteria->with = array();

        $criteria->with[] = 'section';
        $criteria->with[] = 'author';
        $criteria->with[] = 'tags';


        if ( $tag ) {
            $ids = Yii::app()->db->createCommand()
                ->selectDistinct('entity_id')
                ->from('{{entity_tags}}')
                ->where('entity_class = "Article" AND tag_id = (select id from {{tags}} where value = :tag)', array(
                    ':tag' => $tag
                ))->queryColumn();
            $criteria->addInCondition('t.id', $ids);
        }
        $criteria->order = 't.public_date';


        $articles = Article::model()->published()->findAll($criteria);
        $authors = User::model()->hasArticles()->findAll();
        $sections = Section::model()->hasArticles()->findAll();
        $allTags = Tag::model()->hasArticles()->findAll();

        $dataProvider = new CArrayDataProvider($articles, array(
            'pagination' => array(
                'pageSize' => 20
            )
        ));

        $this->render('index', array(
            'dataProvider' => $dataProvider,
            'sections' => $sections,
            'authors' => $authors,
            'tags' => $allTags,
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


    public function actionCreate()
    {
        $model = new Article;

        $this->render('create', array(
            'model' => $model
        ));
    }
}