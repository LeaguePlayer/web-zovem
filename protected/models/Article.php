<?php

/**
* This is the model class for table "{{articles}}".
*
* The followings are the available columns in table '{{articles}}':
    * @property integer $id
    * @property string $title
    * @property string $content
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
*/
class Article extends EActiveRecord
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
            array('content, public_date, create_time, update_time', 'safe'),
            // The following rule is used by search().
            array('id, title, content, section_id, user_id, anonymous, city_id, public_date, node_id, status, sort, create_time, update_time', 'safe', 'on'=>'search'),
        );
    }


    public function relations()
    {
        return array(
        );
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


}
