<?php
/**
 * Миграция m140818_035033_ChangeMapIconAttrInSection
 *
 * @property string $prefix
 */
 
class m140818_035033_ChangeMapIconAttrInSection extends CDbMigration
{
    private $table = '{{section}}';
 
    public function safeUp()
    {
        $this->dropColumn($this->table, 'mapIcon');
        $this->addColumn($this->table, 'img_map', "string COMMENT 'Иконка для карты'");
 
    }
 
    public function safeDown()
    {
        $this->dropColumn($this->table, 'img_map');
        $this->addColumn($this->table, 'mapIcon', "string COMMENT 'Иконка для карты'");
    }
 
}