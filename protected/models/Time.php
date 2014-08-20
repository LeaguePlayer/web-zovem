<?php

/**
* This is the model class for table "{{time}}".
*
* The followings are the available columns in table '{{time}}':
    * @property integer $id
    * @property string $date
    * @property string $start_time
    * @property string $end_time
    * @property integer $contents_id
    * @property integer $event_id
    * @property integer $status
    * @property integer $sort
    * @property string $create_time
    * @property string $update_time
    * @property integer $node_id
*/
class Time extends EActiveRecord
{
    public function tableName()
    {
        return '{{time}}';
    }


    public function rules()
    {
        return array(
            array('contents_id, event_id, status, sort, node_id', 'numerical', 'integerOnly'=>true),
            array('date, start_time, end_time, create_time, update_time', 'safe'),
            // The following rule is used by search().
            array('id, date, start_time, end_time, contents_id, event_id, status, sort, create_time, update_time, node_id', 'safe', 'on'=>'search'),
        );
    }

    public function scopes()
    {
        return array(
            'ordered' => array(
                'order'=>'start_datetime ASC',
            ),
            'unique'=>array(
                'limit' => 1,
            ),
            'startsToday' => array(
                'condition'=>'date = DATE(NOW()) AND start_datetime >= NOW()',
            ),
            'alreadyStarts' => array(
                'condition'=>'start_datetime <= NOW() AND end_datetime >= NOW() ',
            ),
            'future' => array(
                'condition'=>'date > CURDATE()',
            ),
            'upcoming' => array(
                'condition'=>'start_datetime >= NOW()',
            ),
            'archived' => array(
                'condition'=>'end_datetime <= NOW()',
            ),
        );
    }

    public function inDay($day)
    {
        $this->getDbCriteria()->mergeWith(array(
            'condition'=>'date = '.$day,
        ));
        return $this;
    }

    public function when($when)
    {
        if ($when == 'now') {
            return $this->startsToday();
        } 
        else if ($when == 'already') {
            return $this->alreadyStarts();
        }
        else if ($when == 'future') {
            return $this->future();
        }
        else if ($when == 'upcoming') {
            return $this->upcoming();
        }
        else if ($when == 'archived') {
            return $this->archived();
        }
        else if (is_string($when)) {
            return $this->inDay(date('Y-m-d', strtotime($when)));
        }
    }

    public function relations()
    {
        return array(
            'contents'=>array(self::BELONGS_TO, 'Contents', 'contents_id'),
            'event'=>array(self::BELONGS_TO, 'Event', 'event_id'),
            'favorites'=>array(self::HAS_MANY, 'Favorite', 'time_id'),
        );
    }


    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'date' => 'Дата',
            'start_time' => 'Время начала',
            'end_time' => 'Время конца',
            'contents_id' => 'Контент',
            'event_id' => 'Анонс',
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
		$criteria->compare('date',$this->date,true);
		$criteria->compare('start_time',$this->start_time,true);
		$criteria->compare('end_time',$this->end_time,true);
		$criteria->compare('contents_id',$this->contents_id);
		$criteria->compare('event_id',$this->event_id);
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

    public function afterSave()
    {
        $this->isNewRecord = false;
        $this->saveAttributes(array(
            'start_datetime' => $this->date . ' ' . $this->start_time,
            'end_datetime' => $this->date . ' ' . $this->end_time,
        ));
        return parent::afterSave();
    }

    public function inFavorites($user)
    {
        if (Yii::app()->user->isGuest) {
            return ! is_null(Yii::app()->session['Favorites_'.$this->id]);
        }
        else {
            return ! is_null(Favorite::model()->find('user_id=:user_id AND time_id=:time_id', array(
                ':user_id' => $user->id,
                ':time_id' => $this->id,
            )));
        }
    }

    public static function getFavoritesCriteria()
    {
        $criteria = new CDbCriteria();
        $criteria->together = true;
        $criteria->with = array();

        $criteria->with['event'] = array(
            'alias' => 'e',
            'condition' => 'e.status = '.Event::STATUS_PUBLISHED,
            'joinType'=>'INNER JOIN',
        );
        $criteria->with[] = 'event.current_contents';
        $criteria->with[] = 'event.current_contents.section';

        if (! Yii::app()->user->isGuest)
            $criteria->with['favorites'] = array(
                'alias' => 'f',
                'condition' => 'f.user_id = '.Yii::app()->user->id,
                'select' => false,
                'joinType'=>'INNER JOIN',
            );
        else {
            $ids = Time::getFavoriteIds();
            if (!empty($ids))
                $criteria->with['favorites'] = array(
                    'alias' => 'f',
                    'condition' => 'f.time_id IN ('.join(',', $ids).')',
                    'select' => false,
                    'joinType'=>'INNER JOIN',
                );
            else 
                $criteria->with['favorites'] = array(
                    'alias' => 'f',
                    'condition' => 'f.time_id IN (-1)', //здраааааавствуйте
                    'select' => false,
                    'joinType'=>'INNER JOIN',
                );
        }
        return $criteria;
    }

    public static function getFavoriteIds()
    {
        $result = array();
        foreach (Yii::app()->session as $record) {
            $prefix = 'Favorites_';
            if (strpos($record, $prefix) !== false)
                $result[] = substr($record, strlen($prefix));
        }
        return $result;
    }


}
