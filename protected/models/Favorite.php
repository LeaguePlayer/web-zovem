<?php

/**
* This is the model class for table "{{favorite}}".
*
* The followings are the available columns in table '{{favorite}}':
    * @property integer $time_id
    * @property integer $user_id
*/
class Favorite extends EActiveRecord
{
    public function tableName()
    {
        return '{{favorite}}';
    }


    public function rules()
    {
        return array(
            array('time_id, user_id', 'numerical', 'integerOnly'=>true),
            // The following rule is used by search().
            array('time_id, user_id', 'safe', 'on'=>'search'),
        );
    }


    public function relations()
    {
        return array(
            'user'=>array(self::BELONGS_TO, 'User', 'user_id'),
            'time'=>array(self::BELONGS_TO, 'Time', 'time_id'),
        );
    }


    public function attributeLabels()
    {
        return array(
            'time_id' => 'Событие',
            'user_id' => 'Пользователь',
        );
    }



    public function search()
    {
        $criteria=new CDbCriteria;
		$criteria->compare('time_id',$this->time_id);
		$criteria->compare('user_id',$this->user_id);
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }



}
