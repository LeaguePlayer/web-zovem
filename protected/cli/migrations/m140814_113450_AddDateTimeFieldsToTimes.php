<?php
/**
 * Миграция m140814_113450_AddDateTimeFieldsToTimes
 *
 * @property string $prefix
 */
 
class m140814_113450_AddDateTimeFieldsToTimes extends CDbMigration
{
    private $table = '{{time}}';
 
    public function safeUp()
    {
        $this->addColumn($this->table, 'start_datetime', "datetime");
        $this->addColumn($this->table, 'end_datetime', "datetime");
 
    }
 
    public function safeDown()
    {
        $this->dropColumn($this->table, 'start_datetime');
        $this->dropColumn($this->table, 'end_datetime');
    }
 
}