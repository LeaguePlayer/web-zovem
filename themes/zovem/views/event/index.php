
<?php
$this->widget('widgets.event.EventFavorites');
?>


    <div class="filter">
      <div class="left-bar">
        <ul>
          <li role="dropdown-parent">
            <a href="#" title="Выберите дату" role="dropdown-trigger">Сб 7 декабря</a>
            <div class="noshadow"></div>
            <ul class="dropdown-list">
              <li><a href="#">Вс 8 декабря</a></li>
              <li><a href="#">На этой неделе</a></li>
              <li><a href="#">На этих выходных</a></li>
            </ul>
          </li>
          <li role="dropdown-parent">
            <a href="#" title="Выберите тему" role="dropdown-trigger">Тема</a>
            <div class="noshadow"></div>
            <ul class="dropdown-list">
              <li><a href="#">Детям</a></li>
              <li><a href="#">Кино</a></li>
              <li><a href="#">Азия</a></li>
            </ul>
          </li>
        </ul>
      </div>
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


    <div class="events-list">
      <div class="left-bar">
        <ul>
          <li class="current">
            <a href="#">Начинаются сегодня</a>
          </li>
          <li><a href="#">Уже идут в этот день</a></li>
          <li><a href="#">Будут идти</a></li>
          <li><a href="#">Статьи</a></li>
        </ul>
      </div>

    <? $this->widget('zii.widgets.CListView', array(
        'dataProvider' => $dataProvider,
        'template' => '{items}',
        'itemView' => '_item',
        'htmlOptions' => array(
            'class' => 'content-items'
        )
    )) ?>
       </div>

    <div class="text">
      <p>Фолькло́р (англ. folklore — «народная мудрость») — народное творчество, чаще всего именно устное; художественная коллективная творческая деятельность народа, отражающая его жизнь, воззрения, идеалы, принципы; создаваемые народом и бытующие в народных массах поэзия (предание, песни, частушки, анекдоты, сказки, эпос), народная музыка (песни, инструментальные наигрыши и пьесы), театр (драмы, сатирические пьесы, театр кукол), танец, архитектура, изобразительное и декоративно-прикладное искусство.</p>
      <p>Народное творчество, зародившееся глубоко в древности, — историческая основа всей мировой художественной культуры, источник национальных художественных традиций, выразитель народного самосознания. Некоторые исследователи относят к народному творчеству также все виды непрофессионального искусства (самодеятельное искусство, в том числе народные театры).</p>
    </div>