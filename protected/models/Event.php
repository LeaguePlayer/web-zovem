<?php

/**
* This is the model class for table "{{event}}".
*
* The followings are the available columns in table '{{event}}':
    * @property integer $id
    * @property integer $template_id
    * @property integer $contents_id
    * @property integer $user_id
    * @property integer $status
    * @property integer $sort
    * @property string $create_time
    * @property string $update_time
    * @property integer $node_id
*/
class Event extends Material
{

    const STATUS_PUBLISHED = 0;
    const STATUS_ARCHIVED = 1;
    const STATUS_PERIODIC = 2;
    const STATUS_MODERATED = 3;
    const STATUS_DISCARDED = 4;
    const STATUS_EDITED_U = 5;
    const STATUS_EDITED_A = 5;

    public static function getStatus($type = null)
    {
        $types = array(
            Event::STATUS_PUBLISHED => 'Опубликован',
            Event::STATUS_ARCHIVED => 'В архиве',
            Event::STATUS_PERIODIC => 'Постоянный',
            Event::STATUS_MODERATED => 'Ожидает модерации',
            Event::STATUS_DISCARDED => 'Отклонён',
            Event::STATUS_EDITED_U => 'Редактируется',
            Event::STATUS_EDITED_A => 'Модерируется',
        );
        if (!is_null($type))
            return $types[$type];
        else 
            return $types;
    }

    public function tableName()
    {
        return '{{event}}';
    }


    public function rules()
    {
        return array(
            array('template_id, contents_id, user_id, status, sort, node_id', 'numerical', 'integerOnly'=>true),
            array('create_time, update_time', 'safe'),
            // The following rule is used by search().
            array('id, template_id, contents_id, user_id, status, sort, create_time, update_time, node_id', 'safe', 'on'=>'search'),
        );
    }


    public function relations()
    {
        return array(
            'contents'=>array(self::HAS_MANY, 'Contents', 'event_id'),
            'current_contents'=>array(self::BELONGS_TO, 'Contents', 'contents_id'),
            'template'=>array(self::BELONGS_TO, 'Template', 'template_id'),
            'user'=>array(self::BELONGS_TO, 'User', 'user_id'),
            'times'=>array(self::HAS_MANY, 'Time', 'event_id'),
        );
    }


    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'template_id' => 'Шаблон',
            'contents_id' => 'Содержимое',
            'user' => 'Пользователь',
            'user_id' => 'Пользователь',
            'status' => 'Статус',
            'sort' => 'Вес',
            'create_time' => 'Дата создания',
            'update_time' => 'Дата последнего редактирования',
            'node_id' => 'Ссылка на раздел',
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
        ));
    }

    public function search()
    {
        $criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('template_id',$this->template_id);
		$criteria->compare('contents_id',$this->contents_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('status',$this->status);
		$criteria->compare('sort',$this->sort);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('node_id',$this->node_id);
        $criteria->order = 'sort';
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination' => array('pageSize' => 30),
        ));
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function getCurrentTimes()
    {
        return Time::model()->findAll('event_id = :event_id AND contents_id = :contents_id', array(
            ':event_id' => $this->id,
            ':contents_id' => $this->current_contents->id,
        ));
    }

    protected function beforeDelete()
    {
        if ($this->status !== Event::STATUS_DISCARDED) {
            $this->saveAttributes(array('status'=>Event::STATUS_DISCARDED));
            return false;
        }
        else {
            return parent::beforeDelete();
        }
    }


}
