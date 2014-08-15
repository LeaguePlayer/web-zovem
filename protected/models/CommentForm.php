<?php

class CommentForm extends CFormModel
{
    public $text;

    public function rules()
    {
        return array(
            array('text', 'required', 'message' => 'Напишите текст комментария'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'text' => 'Написать комментарий:',
        );
    }
}