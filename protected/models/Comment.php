<?php
/**
* This is the model class for table "{{comment}}".
*
* The followings are the available columns in table '{{comment}}':
* @property string $id
* @property string $type
* @property integer $material_id
* @property string $user_id
* @property string $date
* @property string $name
* @property string $text
* @property integer $public
* @property integer $moder
*/
class Comment extends CActiveRecord
{
    protected $type_of_comment = '';


    public function tableName()
    {
        return '{{comments}}'; // Общая таблица
    }


    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }


    // Для автовыбора классов при поиске
    protected function instantiate($attributes)
    {
        $class = $attributes['type'] . 'Comment'; // Класс выбирается по полю type
        $model = new $class(null);
        return $model;
    }


    public function rules()
    {
        return array(
            array('material_id, type, text', 'required'),
            // закрываем поля от комментатора
            array('material_id, type', 'unsafe', 'on'=>'insert'),

            array('material_id, user_id, type', 'safe', 'on'=>'search'),
        );
    }

    public function relations()
    {
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id',$this->id);
        if ($this->type_of_comment)
            $criteria->compare('type',$this->type_of_comment);
        else
            $criteria->compare('type',$this->type);
        $criteria->compare('material_id',$this->material_id);

        $criteria->compare('public',$this->public);
        $criteria->compare('moder',$this->moder);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    // scope
    public function material($id)
    {
        if ($id){
            $this->getDbCriteria()->mergeWith(array(
                'condition' => 'material_id=:id',
                'params'=>array(':id'=>$id),
            ));
        }
        return $this;
    }

    // scope
    public function type($type)
    {
        if ($type){
            $this->getDbCriteria()->mergeWith(array(
                'condition'=>'type=:type',
                'params'=>array(':type'=>$type),
            ));
        }
        return $this;
    }

    // переопределяем для поиска по типу
    public function find($condition='', $params=array())
    {
        $this->type($this->type_of_comment);
        return parent::find($condition, $params);
    }

    // переопределяем для поиска по типу
    public function findAll($condition='', $params=array())
    {
        $this->type($this->type_of_comment);
        return parent::findAll($condition, $params);
    }

    // переопределяем для поиска по типу
    public function findAllByAttributes($attributes, $condition='', $params=array())
    {
        $this->type($this->type_of_comment);
        return parent::findAllByAttributes($attributes, $condition, $params);
    }

    // переопределяем для поиска по типу
    public function count($condition='', $params=array())
    {
        $this->type($this->type_of_comment);
        return parent::count($condition, $params);
    }

    // храним $this->isNewRecord для проверки в afterSave()
    protected $_isNew;

    protected function beforeValidate()
    {
    	if (parent::beforeValidate()) {
            $this->initType();
    		return true;
    	}
    	return false;
    }

    protected function beforeSave()
    {
        $this->initType();
        // комментарии без типа в базу не пройдут!
        if (!$this->type)
            return false;

        $this->_isNew = $this->isNewRecord;

        if ( $this->isNewRecord ) {
            $this->date = date('Y-m-d H:i:s');
            $this->user_id = Yii::app()->user->id;
        }

        return parent::beforeSave();
    }

    protected function initType()
    {
        if (!$this->type)
            $this->type = $this->type_of_comment;
    }

    protected function afterSave()
    {
        if ($this->_isNew) {
            $this->sendNotifications();
        }
        $this->updateMaterial();
        parent::afterSave();
    }

    protected function afterDelete()
    {
        $this->updateMaterial();
        parent::afterDelete();
    }

    // отправка уведомлений пользователям
    protected function sendNotifications()
    {
        // ...
    }

    // вызов обновления материала
    protected function updateMaterial()
    {
        if ($this->type && $this->material instanceof ICommentDepends) {
            $this->material->updateCommentsState($this);
        }
    }
}