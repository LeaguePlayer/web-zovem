<?php
/**
 * Миграция m140513_111123_AddNodeId
 *
 * @property string $prefix
 */
 
class m140513_111123_AddNodeId extends CDbMigration
{
    // таблицы к удалению, можно использовать '{{table}}'
	private $tables = array('{{tags}}','{{city}}','{{country}}','{{metro}}','{{contents}}','{{section}}','{{time}}','{{template}}','{{event}}');
 
    public function safeUp()
    {
        foreach ($this->tables as $table) {
            $this->addColumn($table, 'node_id', "integer DEFAULT NULL COMMENT 'Ссылка на раздел'");
        }
    }
 
    public function safeDown()
    {
        foreach ($this->tables as $table) {
            $this->dropColumn($table, 'node_id');
        }
    }
 
}