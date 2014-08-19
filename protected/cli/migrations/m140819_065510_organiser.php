<?php
/**
 * Миграция m140819_065510_organiser
 *
 * @property string $prefix
 */
 
class m140819_065510_organiser extends CDbMigration
{
    // таблицы к удалению, можно использовать '{{table}}'
	private $dropped = array('{{organiser}}');
 
    public function safeUp()
    {
        $this->_checkTables();
 
        $this->createTable('{{organiser}}', array(
            'id' => 'pk', // auto increment

            'user_id' => "integer COMMENT 'Пользователь'",
            'title' => "string COMMENT 'Название или имя'",
            'img_image' => "string COMMENT 'Логотип или фотография'",
            'text' => "text COMMENT 'Описание'",
            'country_id' => "integer NOT NULL COMMENT 'Страна'",
            'city_id' => "integer NOT NULL COMMENT 'Город'",
            'metro_id' => "integer COMMENT 'Метро'",
            'address' => "string NOT NULL COMMENT 'Улица, дом, корпус'",
        ),
        'ENGINE=MyISAM DEFAULT CHARACTER SET = utf8 COLLATE = utf8_general_ci');

        $this->insert('{{materials}}', array(
            'class_name' => 'Organiser',
            'name' => 'Устроитель'
        ));
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