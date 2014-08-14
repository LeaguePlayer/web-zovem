<?php

/**
 * Class AnnounceFavorites
 */
class AnnounceFavorites extends CWidget
{
    public $controllerId = 'event';

    public function init()
    {
        parent::init();
        $this->registerScriptFiles();
    }

    public function run()
    {
        $criteria = new CDbCriteria();
        $dataProvider = new CActiveDataProvider('Event', array(
            'criteria' => $criteria,
            'pagination' => false
        ));
        $this->widget('zii.widgets.CListView', array(
            'dataProvider' => $dataProvider,
            'template' => '<div class="slider" style="position: relative; overflow: hidden;">' .
            '   {items}' .
            '</div>',
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