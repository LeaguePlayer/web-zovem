<?php

/**
 * Class AnnounceFavorites
 */
class EventFavorites extends CWidget
{
    public $controllerId = 'event';

    public function init()
    {
        parent::init();
        $this->registerScriptFiles();
    }

    public function run()
    {
        $criteria = Time::getFavoritesCriteria();

        $times = Time::model()->findAll($criteria);

        $dataProvider = new CActiveDataProvider('Time', array(
            'criteria' => $criteria,
            'pagination' => false
        ));

        $this->widget('zii.widgets.CListView', array(
            'dataProvider' => $dataProvider,
            'template' => "{items}",
            'itemsCssClass' => 'slider',
            'itemView' => '_favorite',
            'htmlOptions' => array(
                'class' => 'results'
            ),
        ));
    }



    protected function registerScriptFiles()
    {
        /** @var $cs CClientScript */
        $assetsUrl = CHtml::asset(__DIR__ . DIRECTORY_SEPARATOR . 'assets');
        $cs = Yii::app()->clientScript;
        $cs->registerScriptFile($assetsUrl . '/announces.js', CClientScript::POS_END);
    }
}