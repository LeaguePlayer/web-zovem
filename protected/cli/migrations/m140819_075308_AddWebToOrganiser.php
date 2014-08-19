<?php
/**
 * Миграция m140819_075308_AddWebToOrganiser
 *
 * @property string $prefix
 */
 
class m140819_075308_AddWebToOrganiser extends CDbMigration
{
    private $table = '{{organiser}}';
 
    public function safeUp()
    {
        $this->addColumn($this->table, 'web', "string COMMENT 'Ссылка на сайт'");
 
    }
 
    public function safeDown()
    {
        $this->dropColumn($this->table, 'web');
    }
 
}