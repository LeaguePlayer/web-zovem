<?php
/**
 * Миграция m140818_061101_AddActiveIconToSection
 *
 * @property string $prefix
 */
 
class m140818_061101_AddActiveIconToSection extends CDbMigration
{
    private $table = '{{section}}';
 
    public function safeUp()
    {
        $this->addColumn($this->table, 'img_active', "string");
 
    }
 
    public function safeDown()
    {
        $this->dropColumn($this->table, 'img_active', "string");
    }
 
}