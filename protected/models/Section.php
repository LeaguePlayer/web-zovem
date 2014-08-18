<?php

/**
* This is the model class for table "{{section}}".
*
* The followings are the available columns in table '{{section}}':
    * @property integer $id
    * @property string $title
    * @property integer $status
    * @property integer $sort
    * @property string $create_time
    * @property string $update_time
    * @property integer $node_id
    * @property string $img_icon
    * @property string $img_map
*/
class Section extends EActiveRecord
{
    public function tableName()
    {
        return '{{section}}';
    }


    public function rules()
    {
        return array(
            array('title', 'required'),
            array('status, sort, node_id', 'numerical', 'integerOnly'=>true),
            array('title, img_icon, img_map', 'length', 'max'=>255),
            array('create_time, update_time', 'safe'),
            // The following rule is used by search().
            array('id, title, status, sort, create_time, update_time, node_id, img_icon, img_map', 'safe', 'on'=>'search'),
        );
    }


    public function scopes()
    {
        return array(
            'hasArticles' => array(
                'with' => array(
                    'articles' => array(
                        'select' => false,
                        'joinType' => 'INNER JOIN',
                        'condition' => "articles.status = " . Article::STATUS_PUBLISH,
                    )
                )
            )
        );
    }


    public function relations()
    {
        return array(
            'contents'=>array(self::HAS_MANY, 'Contents', 'section_id'),
            'events'=>array(self::HAS_MANY,'Event',array('event_id'=>'id'),'through'=>'contents'),
            'articles' => array(self::HAS_MANY, 'Article', 'section_id'),
        );
    }


    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'title' => 'Название',
            'status' => 'Статус',
            'sort' => 'Вес для сортировки',
            'create_time' => 'Дата создания',
            'update_time' => 'Дата последнего редактирования',
            'node_id' => 'Ссылка на раздел',
            'img_icon' => 'Иконка',
            'img_map' => 'Иконка для карты',
        );
    }


    public function behaviors()
    {
        return CMap::mergeArray(parent::behaviors(), array(
			'imgBehaviorIcon' => array(
				'class' => 'application.behaviors.UploadableImageBehavior',
				'attributeName' => 'img_icon',
				'versions' => array(
					'icon' => array(
						'centeredpreview' => array(90, 90),
					),
					'small' => array(
						'resize' => array(200, 180),
					)
				),
			),
			'imgBehaviorMap' => array(
				'class' => 'application.behaviors.UploadableImageBehavior',
				'attributeName' => 'img_map',
				'versions' => array(
					'icon' => array(
						'centeredpreview' => array(90, 90),
					),
					'small' => array(
						'resize' => array(200, 180),
					)
				),
			),
			'CTimestampBehavior' => array(
				'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'create_time',
                'updateAttribute' => 'update_time',
                'setUpdateOnCreate' => true,
			),
        ));
    }

    public function search()
    {
        $criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('sort',$this->sort);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('node_id',$this->node_id);
		$criteria->compare('img_icon',$this->img_icon,true);
		$criteria->compare('img_map',$this->img_map,true);
        $criteria->order = 'sort';
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public static function getIndexSections($city_id = null, $date = null)
    {
        $cityCond = '';
        if (! is_null($city_id) && is_numeric($city_id))
            $cityCond = ' AND city_id = '.$city_id;
        return Section::model()->with(
            array(
                'events'=>array(
                    'limit' => 5,
                    'condition' => 'events.status = '.Event::STATUS_PUBLISHED,
                ),
                'events.times'=>array(
                    'limit'=>1,
                    'order'=>'times.start_datetime ASC',
                    'condition'=>'times.end_datetime >= NOW()',
                ),
                'events.current_contents',
            )
        )->findAll();//->published()->sorted()->findAll();
    }


    public function getUrl()
    {
        return Yii::app()->urlManager->createUrl('/sections/view', array('id' => $this->id));
    }
    

}
