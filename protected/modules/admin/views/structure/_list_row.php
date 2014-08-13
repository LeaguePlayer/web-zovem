<?php
	// Формирую текст с необходимым количесвтом отступов в зависимости от уровня вложенности
	$name_text = str_repeat('<span class="offset"></span>', $node->level - 1);
	if ( $isOpen ) {
		$expand_button = TbHtml::link(TbHtml::icon(TbHtml::ICON_MINUS), '#', array('class'=>'expand-button open'));
	} else {
		$expand_button = TbHtml::link(TbHtml::icon(TbHtml::ICON_PLUS), '#', array('class'=>'expand-button'));
	}

	if ( !$node->isRoot() && !$node->isLeaf() ) {
		$name_text .= $expand_button;
	}
	$name_text .= CHtml::link($node->name, array('updateMaterial',"node_id"=>$node->id));

?>

	<? if ( !$node->isRoot()): ?>
<div class='row' data-id='<?= $node->id ?>'>
	<span class='cell name'><?= $name_text ?></span>
</div>
	<? endif; ?>