<?php
/**
 * Миграция m140513_104902_AddFieldsToTags
 *
 * @property string $prefix
 */
 
class m140513_104902_AddFieldsToTags extends CDbMigration
{
    private $table = '{{tags}}';
 
    public function safeUp()
    {
        $this->addColumn($this->table, 'status', "tinyint DEFAULT 1 COMMENT 'Статус'");
        $this->addColumn($this->table, 'sort', "integer COMMENT 'Вес для сортировки'");
        $this->addColumn($this->table, 'create_time', "datetime COMMENT 'Дата создания'");
        $this->addColumn($this->table, 'update_time', "datetime COMMENT 'Дата последнего редактирования'");
 
    }
 
    public function safeDown()
    {
        $this->dropColumn($this->table, 'status');
        $this->dropColumn($this->table, 'sort');
        $this->dropColumn($this->table, 'datetime');
        $this->dropColumn($this->table, 'datetime');
    }
 
}