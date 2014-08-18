<?php

class TagsBehavior extends CActiveRecordBehavior
{
    protected $tags_values;
    protected $_ownerClass;

    public function attach($owner)
    {
        parent::attach($owner);
        $this->_ownerClass = get_class($owner);
        if ( !$owner->metadata->hasRelation('tags') )
            $owner->metaData->addRelation('tags', array($owner::MANY_MANY, 'Tag', '{{entity_tags}}(entity_id, tag_id)', 'on'=>'entity_class="'.$this->_ownerClass.'"'));

    }


    public function tagsWidget($htmlOptions = array())
    {
        $assetsUrl = Yii::app()->controller->getAssetsUrl('admin');
        $cs = Yii::app()->clientScript;
        $cs->registerCssFile($assetsUrl.'/css/bootstrap.tagsinput.css');
        $cs->registerScriptFile($assetsUrl.'/js/bootstrap.tagsinput.js', CClientScript::POS_END);
        $source = Tag::model()->asJson();
$js_tagsinput = <<< EOT
	$(document).ready(function() {
		$('#Tags_tags_values').tagsinput({
			typeahead: {
				source: $source,
				minLength: 0,
			}
		});
	});
EOT;

        $cs->registerScript('tagsinput', $js_tagsinput);
        if ( empty($htmlOptions['label']) ) {
            $htmlOptions['label'] = 'Темы';
        }
        return TbHtml::textFieldControlGroup('Tags[tags_values]', implode(',', $this->getTagsValues()), $htmlOptions);
    }


    public function afterSave($event)
    {
        if ( !Yii::app()->request->isPostRequest ) {
            return;
        }

        if ( !isset($_POST['Tags']) ) {
            return;
        }

        // Сохраняем новый значения в таблице тэгов
        $post_ids = array();

        $post = Yii::app()->request->getPost('Tags');
        $post_tags = !empty($post['tags_values']) ? explode(',', $post['tags_values']) : array();

        if ( !empty($post_tags) ) {
            $all_tags = CHtml::listData(Tag::model()->findAll(), 'id', 'value');
            $new_tags = array_diff($post_tags, $all_tags);
            foreach ($new_tags as $value) {
                $tag = new Tag;
                $tag->value = $value;
                $tag->ref_count = 0;
                if ( $tag->save() ) {
                    $post_ids[] = $tag->id;
                }
            }
            $exist_tags = array_intersect($all_tags, $post_tags);
            $exist_ids = array_keys($exist_tags);
            foreach ($exist_ids as $id) {
                $post_ids[] = $id;
            }
        }


        // обновляем ассоциативную таблицу и счетчики
        $exist_ids = Chtml::listData($this->owner->tags, 'id', 'id');
        $new_ids = array_diff($post_ids, $exist_ids);
        $old_ids = array_diff($exist_ids, $post_ids);

        $criteria = new CDbCriteria();
        $criteria->compare('entity_class', $this->_ownerClass);
        $criteria->compare('entity_id', $this->owner->id);
        $criteria->addInCondition('tag_id', $old_ids);
        Yii::app()->db->createCommand()->delete('{{entity_tags}}', $criteria->condition, $criteria->params);

        $criteria = new CDbCriteria();
        $criteria->addInCondition('id', $old_ids);
        Tag::model()->updateCounters(array('ref_count' => -1), $criteria);

        $successIds = array();
        foreach ( $new_ids as $id ) {
            if ( Yii::app()->db->createCommand()->insert('{{entity_tags}}', array(
                'entity_class' => $this->_ownerClass,
                'entity_id' => $this->owner->id,
                'tag_id' => $id
            )) ) {
                $successIds[] = $id;
            }
        }

        $criteria = new CDbCriteria();
        $criteria->addInCondition('id', $successIds);
        Tag::model()->updateCounters(array('ref_count' => 1), $criteria);

        // Удаляем неиспользуемые тэги
        Yii::app()->db->createCommand()->delete('{{tags}}', 'ref_count=0');

        $this->owner->refresh();
        $this->tags_values = null;
    }


    protected function getTagsValues()
    {
        if ( $this->tags_values === null ) {
            $this->tags_values = CHtml::listData($this->owner->tags, 'id', 'value');
        }
        return $this->tags_values;
    }


    public function afterDelete($event) {
        Yii::app()->db->createCommand()->delete('{{entity_tags}}', 'entity_class="' . $this->_ownerClass . '" AND entity_id='.$this->owner->id);
        $criteria = new CDbCriteria();
        $criteria->addInCondition('id', array_keys($this->tags_values));
        Tag::model()->updateCounters(array('ref_count' => -1), $criteria);
        Yii::app()->db->createCommand()->delete('{{tags}}', 'ref_count=0');
    }
}