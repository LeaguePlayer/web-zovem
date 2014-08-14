<?php
/**
 * Миграция m140814_045549_articles
 *
 * @property string $prefix
 */
 
class m140814_045549_articles extends CDbMigration
{
    // таблицы к удалению, можно использовать '{{table}}'
	private $dropped = array('{{articles}}', '{{article_tags}}');
 
    public function safeUp()
    {
        $this->_checkTables();
 
        $this->createTable('{{articles}}', array(
            'id' => 'pk', // auto increment
            'title' => 'varchar(256) COMMENT "Заголовок"',
            'content' => 'text COMMENT "Текст статьи"',
			'section_id' => "integer COMMENT 'Раздел'",
			'user_id' => "integer COMMENT 'Автор'",
			'anonymous' => "tinyint COMMENT 'Опубликовать анонимно'",
			'city_id' => "integer COMMENT 'Город'",
            'public_date' => "datetime COMMENT 'Дата публикации'",
			'node_id' => "integer",
			'status' => "tinyint COMMENT 'Статус'",
			'sort' => "integer COMMENT 'Вес для сортировки'",
            'create_time' => "datetime COMMENT 'Дата создания'",
            'update_time' => "datetime COMMENT 'Дата последнего редактирования'",
        ), 'ENGINE=MyISAM DEFAULT CHARACTER SET = utf8 COLLATE = utf8_general_ci');


        $this->createTable('{{article_tags}}', array(
            'article_id' => 'integer',
            'tag_id' => 'integer'
        ), 'ENGINE=MyISAM DEFAULT CHARACTER SET = utf8 COLLATE = utf8_general_ci');
        $this->addPrimaryKey('PRIMARY', '{{article_tags}}', 'article_id, tag_id');

        $this->insert('{{materials}}', array(
            'class_name' => 'Article',
            'name' => 'Статья'
        ));
    }
 
    public function safeDown()
    {
        $this->delete('{{materials}}', 'class_name = "Article"');
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