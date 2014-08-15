
    <div class="most-interesting">
      <div class="top-bar">
        <div class="date-filter">
          Самое интересное на <a href="#">Сегодня</a> или <a href="#">Завтра</a>
        </div>
        <div class="cities-filter">
          <label for="myonoffswitch">Показывать во всех городах</label> 
          <div class="onoffswitch">
              <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch">
              <label class="onoffswitch-label" for="myonoffswitch">
                  <div class="onoffswitch-inner"></div>
                  <div class="onoffswitch-switch"></div>
              </label>
          </div>
        </div>
      </div>

      <div class="items">
      <? foreach($sections as $section) :?>
        <div class="item">
          <a href="#" class="rss" title="RSS"></a>
          <h2><a href="#" title="Зовём <?= $section->title;?>"><?= $section->title;?></a><span><img src="<?= $section->getImageUrl();?>" alt="Зовём <?= $section->title;?>"></span></h2>
          <ul>
          	<? foreach($section->events as $event) :?>
            <li<? if($event->current_contents->type):?> class="active"<?endif;?>>
              <p class="link">
                <a href="/event/<?= $event->id;?>" title="<?= $event->current_contents->title; ?>"><?= $event->current_contents->title; ?></a>
                <span class="date"><?= SiteHelper::russianDate($event->current_contents->times[0]->start_datetime, false); ?></span>
              </p>
              <p class="tags">
                <a href="#" title="тем Детям">детям</a>
                <a href="#" title="тем Семейный">семейный</a>
              </p>
            </li>
        	<? endforeach; ?>
          </ul>
        </div>
    	<? endforeach; ?>
      </div>
    </div>