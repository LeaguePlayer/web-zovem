<?php
/**
 * Миграция m140513_075130_contents
 *
 * @property string $prefix
 */
 
class m140513_075130_contents extends CDbMigration
{
    // таблицы к удалению, можно использовать '{{table}}'
	private $dropped = array('{{contents}}');
 
    public function safeUp()
    {
        $this->_checkTables();
 
        $this->createTable('{{contents}}', array(
            'id' => 'pk', // auto increment

            'template_id' => "integer COMMENT 'Шаблон'",
            'event_id' => "integer COMMENT 'Анонс'",
            'user_id' => "integer COMMENT 'Пользователь'",

            'title' => "string NOT NULL COMMENT 'Заголовок'",
            'country_id' => "integer NOT NULL COMMENT 'Страна'",
            'city_id' => "integer NOT NULL COMMENT 'Город'",
            'metro_id' => "integer COMMENT 'Метро'",
            'address' => "string NOT NULL COMMENT 'Улица, дом, корпус'",
            'way' => "text COMMENT 'Как добраться'",
            'wswg_body' => "text NOT NULL COMMENT 'Тело анонса'",
            'is_free' => "boolean COMMENT 'Бесплатное мероприятие'",
            'price' => "string COMMENT 'Стоимость'",
            'terms' => "text COMMENT 'Условия участия'",

            'img_photo' => "string COMMENT 'Фото'",
            'img_org' => "string COMMENT 'Логотип организации'",
            'org' => "string COMMENT 'Название организации'",
            'web' => "string COMMENT 'Сайт'",
            'phone' => "string COMMENT 'Контактный телефон'",
            'email' => "string COMMENT 'Контактный email'",
 
            'section_id' => "integer NOT NULL COMMENT 'Рубрика'",

            'type' => "tinyint DEFAULT 0 COMMENT 'Рекомендуемое'",

            'comment' => "text COMMENT 'Комментарий'",
            'label' => "text COMMENT 'Пометка'",
            'is_federal' => "boolean COMMENT 'Показывать в других городах'",

			
			'status' => "tinyint COMMENT 'Статус'",
			'sort' => "integer COMMENT 'Вес для сортировки'",
            'create_time' => "datetime COMMENT 'Дата создания'",
            'update_time' => "datetime COMMENT 'Дата последнего редактирования'",
        ),
        'ENGINE=MyISAM DEFAULT CHARACTER SET = utf8 COLLATE = utf8_general_ci');
    }
 
    public function safeDown()
    {
        $this->_checkTables();
    }
 
    /**
     * Удаляет таблицы, указанные в $this->dropped из базы.
     * Наименование таблиц могут сожержать двойные фигурные скобки для указания
     * необходимости добавления префикса, например, если указано имя {{table}}
     * в действительности будет удалена таблица 'prefix_table'.
     * Префикс таблиц задается в файле конфигурации (для консоли).
     */
    private function _checkTables ()
    {
        if (empty($this->dropped)) return;
 
        $table_names = $this->getDbConnection()->getSchema()->getTableNames();
        foreach ($this->dropped as $table) {
            if (in_array($this->tableName($table), $table_names)) {
                $this->dropTable($table);
            }
        }
    }
 
    /**
     * Добавляет префикс таблицы при необходимости
     * @param $name - имя таблицы, заключенное в скобки, например {{имя}}
     * @return string
     */
    protected function tableName($name)
    {
        if($this->getDbConnection()->tablePrefix!==null && strpos($name,'{{')!==false)
            $realName=preg_replace('/{{(.*?)}}/',$this->getDbConnection()->tablePrefix.'$1',$name);
        else
            $realName=$name;
        return $realName;
    }
 
    /**
     * Получение установленного префикса таблиц базы данных
     * @return mixed
     */
    protected function getPrefix(){
        return $this->getDbConnection()->tablePrefix;
    }
}