<?php
    Yii::app()->clientScript->registerScriptFile( $this->getAssetsUrl().'/js/structure.list.js', CClientScript::POS_END );
?>


<?php $rootNode = Structure::model()->roots()->find(); ?>
<div id="structure-grid">
    <?php if ( $rootNode ): ?>
        <ul class="root">
            <li><?php echo $this->renderPartial('_list_row', array(
					'node'=>$rootNode
				)) ?>
                <?php
                    $descendants = $rootNode->descendants()->findAll();
                    $lastLevel = $rootNode->level;
                ?>
                <? if ( count($descendants) ): ?>
                    <ul>
                        <? foreach ( $descendants as $node ): ?>
                            <?php if ( $node->level < $lastLevel ) {
                                echo str_repeat('</ul></li>', $lastLevel - $node->level);
                            } ?>
                            <?php $lastLevel = $node->level ?>
							<li> <!-- Вывод одной строки -->
								<?php
									$isOpen = $openNode && ( $openNode->id == $node->id || $openNode->isDescendantOf($node) );
								?>
								<?php echo $this->renderPartial('_list_row', array(
									'node'=>$node,
									'isOpen' => $isOpen
								)) ?>
								<?php if ( !$node->isLeaf() ): ?>
									<ul<? if ( !$isOpen ) echo ' style="display: none;"' ?>>
								<?php endif ?>
							</li>
                        <?php endforeach ?>
                    </ul>
                <?php endif ?>
            </li>
        </ul>
    <?php endif ?>
</div>