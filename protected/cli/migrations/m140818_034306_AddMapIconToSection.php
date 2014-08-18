<?php
/**
 * Миграция m140818_034306_AddMapIconToSection
 *
 * @property string $prefix
 */
 
class m140818_034306_AddMapIconToSection extends CDbMigration
{
    private $table = '{{section}}';
 
    public function safeUp()
    {
        $this->addColumn($this->table, 'mapIcon', "string");
 
    }
 
    public function safeDown()
    {
        $this->dropColumn($this->table, 'mapIcon', "string");
    }
 
}