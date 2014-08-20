 	
	<h1>Места и люди</h1>

    <div class="filter">
      <div class="right-bar">
        <ul>
          <li>
            <label for="myonoffswitch">Показывать во всех городах</label> 
            <div class="onoffswitch">
                <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch">
                <label class="onoffswitch-label" for="myonoffswitch">
                    <div class="onoffswitch-inner"></div>
                    <div class="onoffswitch-switch"></div>
                </label>
            </div>
          </li>
        </ul>
      </div>
    </div>

 	<div class="most-interesting placespeople">
      
	    <? $this->widget('zii.widgets.CListView', array(
	        'dataProvider' => $dataProvider,
	        'template' => '{items}',
	        'itemView' => '_item',
	        'htmlOptions' => array(
	            'class' => 'items'
	        )
	    )) ?>
    </div>