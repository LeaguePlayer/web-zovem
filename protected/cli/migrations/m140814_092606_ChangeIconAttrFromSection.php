<?php
/**
 * Миграция m140814_092606_ChangeIconAttrFromSection
 *
 * @property string $prefix
 */
 
class m140814_092606_ChangeIconAttrFromSection extends CDbMigration
{
    private $table = '{{section}}';
 
    public function safeUp()
    {
        $this->dropColumn($this->table, 'icon');
        $this->addColumn($this->table, 'img_icon', "string COMMENT 'Иконка'");
 
    }
 
    public function safeDown()
    {
        $this->dropColumn($this->table, 'img_icon');
        $this->addColumn($this->table, 'icon', "string COMMENT 'Иконка'");
    }
 
}