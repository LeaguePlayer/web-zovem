<?php

/**
* This is the model class for table "{{city}}".
*
* The followings are the available columns in table '{{city}}':
    * @property integer $id
    * @property integer $country_id
    * @property string $title
    * @property integer $status
    * @property integer $sort
    * @property string $create_time
    * @property string $update_time
*/
class City extends Material
{
    public function tableName()
    {
        return '{{city}}';
    }


    public function rules()
    {
        return array(
            array('country_id, title', 'required'),
            array('country_id, status, sort', 'numerical', 'integerOnly'=>true),
            array('title', 'length', 'max'=>255),
            array('create_time, update_time', 'safe'),
            // The following rule is used by search().
            array('id, country_id, title, status, sort, create_time, update_time', 'safe', 'on'=>'search'),
        );
    }


    public function relations()
    {
        return array(
            'country'=>array(self::BELONGS_TO, 'Country', 'country_id'),
            'contents'=>array(self::HAS_MANY, 'Contents', 'city_id'),
            'metros'=>array(self::HAS_MANY, 'Metro', 'city_id'),
        );
    }


    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'country_id' => 'Страна',
            'title' => 'Название',
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
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('title',$this->title,true);
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
