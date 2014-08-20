<?php

/**
* This is the model class for table "{{organiser}}".
*
* The followings are the available columns in table '{{organiser}}':
    * @property integer $id
    * @property integer $user_id
    * @property string $title
    * @property string $img_image
    * @property string $text
    * @property integer $country_id
    * @property integer $city_id
    * @property integer $metro_id
    * @property string $address
*/
class Organiser extends EActiveRecord
{
    public function tableName()
    {
        return '{{organiser}}';
    }


    public function rules()
    {
        return array(
            array('country_id, city_id, address, title, user_id', 'required'),
            array('user_id, country_id, city_id, metro_id', 'numerical', 'integerOnly'=>true),
            array('title, img_image, address, web', 'length', 'max'=>255),
            array('text', 'safe'),
            // The following rule is used by search().
            array('id, user_id, title, img_image, web, text, country_id, city_id, metro_id, address', 'safe', 'on'=>'search'),
        );
    }


    public function relations()
    {
        return array(
            'user'=>array(self::BELONGS_TO, 'User', 'user_id'),
            'country'=>array(self::BELONGS_TO, 'Country', 'country_id'),
            'city'=>array(self::BELONGS_TO, 'City', 'city_id'),
            'metro'=>array(self::BELONGS_TO, 'Metro', 'metro_id'),
            'events'=>array(self::HAS_MANY, 'Event', array('id'=>'user_id'), 'through'=>'user' ),
            'times'=>array(self::HAS_MANY, 'Time', array('id'=>'event_id'), 'through'=>'events' ),
        );
    }


    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'user' => 'Пользователь',
            'title' => 'Название или имя',
            'img_image' => 'Логотип или фотография',
            'text' => 'Описание',
            'country_id' => 'Страна',
            'city_id' => 'Город',
            'metro_id' => 'Метро',
            'address' => 'Улица, дом, корпус',
            'web' => 'Ссылка на сайт',
        );
    }


    public function behaviors()
    {
        return CMap::mergeArray(parent::behaviors(), array(
			'imgBehaviorImage' => array(
				'class' => 'application.behaviors.UploadableImageBehavior',
				'attributeName' => 'img_image',
				'versions' => array(
					'small' => array(
						'resize' => array(50, 40),
					)
				),
			),
            'PurifyText' => array(
                'class' => 'application.behaviors.DPurifyTextBehavior',
                'sourceAttribute' => 'text',
                'destinationAttribute' => 'text',
                'purifierOptions' => array(
                    'Core.EscapeInvalidTags' => true,
                    'AutoFormat.AutoParagraph' => false,
                    'HTML.Allowed' => 'b,i,p',
                    'HTML.Nofollow' => true,
                ),
                'updateOnAfterFind' => false,
            )
        ));
    }

    public function search()
    {
        $criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('img_image',$this->img_image,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('metro_id',$this->metro_id);
        $criteria->compare('address',$this->address,true);
		$criteria->compare('web',$this->web,true);
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }


}
