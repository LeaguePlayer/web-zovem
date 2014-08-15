<?php

/**
 * This is the model class for table "{{news_tags}}".
 *
 * The followings are the available columns in table '{{news_tags}}':
 * @property integer $id
 * @property string $value
 */
class Tag extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{tags}}';
	}

	public function defaultScope()
	{
		return array(
			'order' => 'value'
		);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('value', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, value', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'articles' => array(self::MANY_MANY, 'Article', '{{entity_tags}}(tag_id, entity_id)',
                'on' => 'entity_class="Article"'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'value' => 'Тема',
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
                        'condition' => 'articles.status = ' . Article::STATUS_PUBLISH
                    )
                )
            )
        );
    }


	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('value',$this->value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


    public function asJson()
    {
        $all = Yii::app()->db->createCommand()
            ->select('value')->from(self::tableName())
            ->queryColumn();
        return CJSON::encode($all);
    }
}
