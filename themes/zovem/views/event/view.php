

    <div class="event">
      <div class="float-fix">
        <h1><?= $event->current_contents->title; ?><span><img src="<?= $event->current_contents->section->getImageUrl(); ?>" alt="<?= $event->current_contents->title; ?>"></span></h1>
        <div class="right-bar">
          <div class="when">
            <p class="date"><?= SiteHelper::russianDate($time->date, false);?></p>
            <p class="time"><?= SiteHelper::russianDayTime($time->start_datetime);?></p>
            <? if ($event->current_contents->is_free): ?><p class="for-free"></p><? endif ;?>
          </div>
          <div class="where">
            <? if ($event->current_contents->img_org): ?><a href="<?= $event->current_contents->web ;?>" target="_blank" class="logo"><img src="<?= $event->current_contents->imgBehaviorOrg->getImageUrl('normal') ;?>" alt="<?= $event->current_contents->org;?>"></a><? endif; ?>
            <p><?= nl2br(strip_tags($event->current_contents->way));?></p>
            <? if ($event->current_contents->web):?><a href="<?= $event->current_contents->web;?>" target="_blank"><?= $event->current_contents->web;?></a><? endif; ?>
          </div>
        </div>
        <div class="info">
          <div class="content">
          	<?= $event->current_contents->wswg_body; ?>
          </div>
            <p class="tags">
                <? foreach ( $event->current_contents->tags as $tag ): ?>
                    <a href="<?= $this->createUrl('/event/index', array('tag' => $tag->value)) ?>"><?= $tag->value ?></a>
                <? endforeach ?>
            </p>
          <div class="invitation">
            <div class="invite">
              <div class="onoffswitch">
                <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch">
                <label class="onoffswitch-label" for="myonoffswitch">
                    <div class="onoffswitch-inner"></div>
                    <div class="onoffswitch-switch"></div>
                </label>
              </div>
              <label for="myonoffswitch">Пригласить друзей на мероприятие</label>
            </div>
            <? if ($time->inFavorites(Yii::app()->user)): ?>
            <span class="button">В избранном</span>
            <? else: ?>
            <a href="#" class="button addToFavorites" data-id="<?= $time->id;?>">Добавить в избранное</a>
            <? endif; ?>
          </div>
        </div>
      </div>
      <div class="float-fix">
        <div class="extra">
          <div class="map" id="YMapsID">
          </div>
          <div class="sharing">
            <div class="social">
              <a href="#"><img src="./images/vk.png"></a>
              <a href="#"><img src="./images/fb.png"></a>
              <a href="#"><img src="./images/tw.png"></a>
              <a href="#"><img src="./images/ok.png"></a>
            </div>

            <div class="lcomments">
                <a href="#" class="comments" title="Комментарии"><?= $article->comments_count ?></a>
                <a href="#" class="likes liked" title="Нравится">120</a>
            </div>
        </div>


            <? $this->widget('widgets.comment.CommentsWidget', array(
                'type' => EventComment::TYPE_OF_COMMENT,
                'material_id' => $event->id
            )) ?>

        </div>
        <div class="right-bar">
        <? if ($event->current_contents->terms || $event->current_contents->price): ?>
          <h2>Условия участия:</h2>
        <? if($event->current_contents->price): ?>
          <div class="price">
            Стоимость участия: <span><?= $event->current_contents->price; ?></span>
          </div>
      	<? endif; ?>
        <? if($event->current_contents->terms): ?>
          <div class="terms">
          	<?= $event->current_contents->terms; ?>
          </div>
         <? endif; ?>
        <? endif; ?>
          <h2>Ещё на эту тему:</h2>
          <ul>
            <li>
              <a href="#">Кинодень Японии: современное кино — Такэси Китано и Такаси Миикэ</a>
              <span class="date">Мероприятия, 24 августа</span>
            </li>
            <li>
              <a href="#">Кинодень Японии: современное кино — Такэси Китано и Такаси Миикэ</a>
              <span class="date">Мероприятия, 24 августа</span>
            </li>
            <li>
              <a href="#">Кинодень Японии: современное кино — Такэси Китано и Такаси Миикэ</a>
              <span class="date">Мероприятия, 24 августа</span>
            </li>
            <li>
              <a href="#">Кинодень Японии: современное кино — Такэси Китано и Такаси Миикэ</a>
              <span class="date">Мероприятия, 24 августа</span>
            </li>
          </ul>
        </div>
      </div>
     </div>

