<?php

/**
* This is the model class for table "{{contents}}".
*
* The followings are the available columns in table '{{contents}}':
    * @property integer $id
    * @property integer $template_id
    * @property integer $event_id
    * @property integer $user_id
    * @property string $title
    * @property integer $country_id
    * @property integer $city_id
    * @property integer $metro_id
    * @property string $address
    * @property string $way
    * @property string $wswg_body
    * @property integer $is_free
    * @property string $price
    * @property string $terms
    * @property string $img_photo
    * @property string $img_org
    * @property string $org
    * @property string $web
    * @property string $phone
    * @property string $email
    * @property integer $section_id
    * @property integer $type
    * @property string $comment
    * @property string $label
    * @property integer $is_federal
    * @property integer $status
    * @property integer $sort
    * @property string $create_time
    * @property string $update_time
    * @property integer $node_id
*/
class Contents extends EActiveRecord
{
    public function tableName()
    {
        return '{{contents}}';
    }


    public function rules()
    {
        return array(
            array('title, country_id, city_id, address, wswg_body, section_id', 'required'),
            array('template_id, event_id, user_id, country_id, city_id, metro_id, is_free, section_id, type, is_federal, status, sort, node_id', 'numerical', 'integerOnly'=>true),
            array('title, address, price, img_photo, img_org, org, web, phone, email', 'length', 'max'=>255),
            array('way, terms, comment, label, create_time, update_time', 'safe'),
            // The following rule is used by search().
            array('id, template_id, event_id, user_id, title, country_id, city_id, metro_id, address, way, wswg_body, is_free, price, terms, img_photo, img_org, org, web, phone, email, section_id, type, comment, label, is_federal, status, sort, create_time, update_time, node_id', 'safe', 'on'=>'search'),
        );
    }


    public function relations()
    {
        return array(
            'user'=>array(self::BELONGS_TO, 'User', 'user_id'),
            'template'=>array(self::BELONGS_TO, 'Template', 'template_id'),
            'event'=>array(self::BELONGS_TO, 'Event', 'event_id'),
            'country'=>array(self::BELONGS_TO, 'Country', 'country_id'),
            'city'=>array(self::BELONGS_TO, 'City', 'city_id'),
            'metro'=>array(self::BELONGS_TO, 'Metro', 'metro_id'),
            'time'=>array(self::HAS_ONE, 'Time', 'contents_id'),
            'event'=>array(self::HAS_ONE, 'Event', 'contents_id'),
            'times'=>array(self::HAS_MANY, 'Time', 'contents_id'),
            'section'=>array(self::BELONGS_TO, 'Section', 'section_id'),
        );
    }


    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'template_id' => 'Шаблон',
            'event_id' => 'Анонс',
            'user_id' => 'Пользователь',
            'title' => 'Заголовок',
            'country_id' => 'Страна',
            'city_id' => 'Город',
            'city' => 'Город',
            'metro_id' => 'Метро',
            'address' => 'Улица, дом, корпус',
            'way' => 'Как добраться',
            'wswg_body' => 'Полное описание мероприятия',
            'is_free' => 'Бесплатное мероприятие',
            'price' => 'Стоимость',
            'terms' => 'Условия участия',
            'img_photo' => 'Фото',
            'img_org' => 'Логотип организации',
            'org' => 'Название организации',
            'web' => 'Сайт',
            'phone' => 'Контактный телефон',
            'email' => 'Контактный email',
            'section_id' => 'Рубрика',
            'type' => 'Рекомендуемое',
            'comment' => 'Комментарий',
            'label' => 'Пометка',
            'is_federal' => 'Показывать в других городах',
            'status' => 'Статус',
            'sort' => 'Вес для сортировки',
            'create_time' => 'Дата создания',
            'update_time' => 'Дата последнего редактирования',
            'node_id' => 'Ссылка на раздел',
        );
    }


    public function behaviors()
    {
        return CMap::mergeArray(parent::behaviors(), array(
			'imgBehaviorPhoto' => array(
				'class' => 'application.behaviors.UploadableImageBehavior',
				'attributeName' => 'img_photo',
				'versions' => array(
					'icon' => array(
						'centeredpreview' => array(90, 90),
					),
					'small' => array(
						'resize' => array(200, 180),
					)
				),
			),
			'imgBehaviorOrg' => array(
				'class' => 'application.behaviors.UploadableImageBehavior',
				'attributeName' => 'img_org',
				'versions' => array(
					'icon' => array(
						'centeredpreview' => array(90, 90),
					),
                    'small' => array(
                        'resize' => array(200, 180),
                    ),
                    'normal' => array(
                        'resize' => array(110),
                    )
				),
			),
			'CTimestampBehavior' => array(
				'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'create_time',
                'updateAttribute' => 'update_time',
                'setUpdateOnCreate' => true,
			),
            'TagsBehavior' => array(
                'class' => 'application.behaviors.TagsBehavior'
            ),
        ));
    }

    public function search()
    {
        $criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('template_id',$this->template_id);
		$criteria->compare('event_id',$this->event_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('metro_id',$this->metro_id);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('way',$this->way,true);
		$criteria->compare('wswg_body',$this->wswg_body,true);
		$criteria->compare('is_free',$this->is_free);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('terms',$this->terms,true);
		$criteria->compare('img_photo',$this->img_photo,true);
		$criteria->compare('img_org',$this->img_org,true);
		$criteria->compare('org',$this->org,true);
		$criteria->compare('web',$this->web,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('section_id',$this->section_id);
		$criteria->compare('type',$this->type);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('label',$this->label,true);
		$criteria->compare('is_federal',$this->is_federal);
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

    public function initDefaults()
    {
        $this->is_free = true;
    }

}
