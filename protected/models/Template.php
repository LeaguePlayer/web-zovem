<?php

/**
* This is the model class for table "{{template}}".
*
* The followings are the available columns in table '{{template}}':
    * @property integer $id
    * @property integer $user_id
    * @property integer $status
    * @property integer $sort
    * @property string $create_time
    * @property string $update_time
    * @property integer $node_id
*/
class Template extends Material
{
    public function tableName()
    {
        return '{{template}}';
    }


    public function rules()
    {
        return array(
            array('user_id, status, sort, node_id', 'numerical', 'integerOnly'=>true),
            array('create_time, update_time', 'safe'),
            // The following rule is used by search().
            array('id, user_id, status, sort, create_time, update_time, node_id', 'safe', 'on'=>'search'),
        );
    }


    public function relations()
    {
        return array(
            'events'=>array(self::HAS_MANY, 'Event', 'template_id'),
            'contents'=>array(self::HAS_ONE, 'Contents', 'template_id'),
            'user'=>array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }


    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('status',$this->status);
		$criteria->compare('sort',$this->sort);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('node_id',$this->node_id);
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
