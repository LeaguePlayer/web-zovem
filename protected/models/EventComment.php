<?php

class EventComment extends Comment
{
    // совпадает с префиксом подкласса комментария и именем класса сущности
    const TYPE_OF_COMMENT = 'Event';

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function __construct($scenario='insert') {
        // устанавливаем наш тип полю базового класса
        $this->type_of_comment = self::TYPE_OF_COMMENT;
        parent::__construct($scenario);
    }

    // Добавим ссылку на нашего специфического владельца
    public function relations() {
        return array_merge(parent::relations(), array(
            'material'=>array(self::BELONGS_TO, self::TYPE_OF_COMMENT, 'material_id'),
        ));
    }
}