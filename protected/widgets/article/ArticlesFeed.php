<?php

class ArticlesFeed extends CWidget
{
    public $limit = 4;

    public $criteria = null;


    public function run()
    {
        $criteria = new CDbCriteria();
        $criteria->limit = $this->limit;

        if ( $this->criteria ) {
            $criteria->mergeWith($this->criteria);
        }

        $articles = Article::model()->published()->with(array('section', 'author'))->findAll($criteria);

        $this->render('feed', array(
            'articles' => $articles
        ));
    }
}