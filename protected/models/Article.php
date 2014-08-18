<?php

/**
* This is the model class for table "{{articles}}".
*
* The followings are the available columns in table '{{articles}}':
    * @property integer $id
    * @property string $title
    * @property string $content
    * @property string $annotate
    * @property integer $section_id
    * @property integer $user_id
    * @property integer $anonymous
    * @property integer $city_id
    * @property string $public_date
    * @property integer $node_id
    * @property integer $status
    * @property integer $sort
    * @property string $create_time
    * @property string $update_time
    * @property integer $comments_count
    * @property integer $comments_new_count
    * @property integer $likes_count
*/
class Article extends EActiveRecord implements ICommentDepends
{
    public function tableName()
    {
        return '{{articles}}';
    }


    public function rules()
    {
        return array(
            array('section_id, user_id, anonymous, city_id, node_id, status, sort', 'numerical', 'integerOnly'=>true),
            array('title', 'length', 'max'=>256),
            array('content, public_date, create_time, update_time, tags', 'safe'),
            // The following rule is used by search().
            array('id, title, content, section_id, user_id, anonymous, city_id, public_date, node_id, status, sort, create_time, update_time', 'safe', 'on'=>'search'),
        );
    }


    public function relations()
    {
        return array(
            'section' => array(self::BELONGS_TO, 'Section', 'section_id'),
            'author' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }


    public function updateCommentsState($comment)
    {
        $comments_count = ArticleComment::model()->material($this->id)->count('public=1');
        $comments_new_count = ArticleComment::model()->material($this->id)->count('public=1 AND moder=0');

        $this->updateByPk($this->id, array('comments_count' => $comments_count));
        $this->updateByPk($this->id, array('comments_new_count' => $comments_new_count));
    }


    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'title' => 'Заголовок',
            'content' => 'Текст статьи',
            'section_id' => 'Раздел',
            'user_id' => 'Автор',
            'anonymous' => 'Опубликовать анонимно',
            'city_id' => 'Город',
            'public_date' => 'Дата публикации',
            'node_id' => 'Node',
            'status' => 'Статус',
            'sort' => 'Вес для сортировки',
            'create_time' => 'Дата создания',
            'update_time' => 'Дата последнего редактирования',
            'tags' => 'Тема'
        );
    }


    public function behaviors()
    {
        return CMap::mergeArray(parent::behaviors(), array(
			'CTimestampBehavior' => array(
				'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'create_time',
                'updateAttribute' => 'update_time',
                'setUpdateOnCreate' => true,
			),
            'TagsBehavior' => array(
                'class' => 'application.behaviors.TagsBehavior'
            ),
//            'PurifyText' => array(
//                'class' => 'application.behaviors.DPurifyTextBehavior',
//                'sourceAttribute' => 'content',
//                'destinationAttribute' => 'annotate',
//                'purifierOptions' => array(
//                    'Core.EscapeInvalidTags' => true,
//                    'AutoFormat.AutoParagraph' => false,
//                    'AutoFormat.Linkify' => true,
//                    'HTML.Allowed' => 'b,i,a[href]',
//                    'HTML.Nofollow' => true,
//                ),
//                'updateOnAfterFind' => false,
//            )
        ));
    }

    public function search()
    {
        $criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('section_id',$this->section_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('anonymous',$this->anonymous);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('public_date',$this->public_date,true);
		$criteria->compare('node_id',$this->node_id);
		$criteria->compare('status',$this->status);
		$criteria->compare('sort',$this->sort);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
        $criteria->order = 'sort';
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }


    public function beforeSave()
    {
    	if (parent::beforeSave()) {
            if ( empty($this->annotate) ) {
                $this->annotate = SiteHelper::intro($this->content, 400, '...');
            }
    		return true;
    	}
    	return false;
    }


    public function getUrl()
    {
        return Yii::app()->urlManager->createUrl('/article/view', array('id' => $this->id));
    }
}
