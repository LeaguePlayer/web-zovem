<?php

class CommentsWidget extends CWidget
{
    public $material_id;
    public $type;

    protected $user;

    public function init()
    {
        parent::init();
        $this->registerScriptFiles();
    }

    public function run()
    {
        if (!$this->user) $this->user = User::model()->findByPk(Yii::app()->user->getId());
        if (!$this->material_id) throw new CException('Not setted a Material_ID');
        if (!$this->type) throw new CException('Not setted a TYPE of comments');

        $model = new CommentForm();
        if (!$this->user) $model->scenario = 'anonim';


        if ( isset($_POST['CommentWidget']) ) {
            switch ( $_POST['CommentWidget']['action'] ) {
                case 'delete':
                    $id  = $_POST['CommentWidget']['id'];
                    if ( Comment::model()->deleteByPk($id) ) {
                        echo CJSON::encode(array('success' => true));
                        Yii::app()->end();
                    }
                    break;
            }
        }


        if ( isset($_POST['CommentForm']) ) {
            $model->attributes = $_POST['CommentForm'];

            if($model->validate()){

                $className = $this->type . 'Comment';

                $comment = new $className;
                $comment->attributes = $_POST['CommentForm'];
                $comment->material_id = $this->material_id;
                $comment->public = 1;
                $comment->moder = 0;

                if ($this->user)
                    $comment->user_id = $this->user->id;


                if ($comment->save()) {
                    Yii::app()->user->setFlash('comment-form','Ваш коментарий добавлен');
                    Yii::app()->controller->refresh();
                }
            }
        }


        $comments = Comment::model()
            ->type($this->type)
            ->material($this->material_id)
            ->with('user')
            ->findAll(array('order'=>'t.id ASC'));


        $this->render('comments', array(
            'comments' => $comments,
            'model' => $model,
            'user' => $this->user,
            'material_id' => $this->material_id,
            'type' => $this->type,
        ));
    }


    protected function registerScriptFiles()
    {
        /** @var $cs CClientScript */
        $assetsUrl = CHtml::asset(__DIR__ . DIRECTORY_SEPARATOR . 'assets');
        $cs = Yii::app()->clientScript;
        $cs->registerCssFile($assetsUrl . '/comments.css');
        $cs->registerScriptFile($assetsUrl . '/comments.js', CClientScript::POS_END);
    }
}