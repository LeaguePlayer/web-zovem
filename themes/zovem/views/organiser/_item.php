
        <div class="item">
          <h2><a href="#" title="Зовём <?= $data->title; ?>"><?= $data->title; ?></a><span><img src="<?= $data->getImageUrl(); ?>" alt="<?= $data->title; ?>"></span></h2>
          <ul>
            <? foreach($data->events as $event): ?>
              <li>
                <div class="logo"><a href="/organiser/view/id/<?= $event->organiser->id;?>" title="<?= $event->organiser->title;?>"><img src="<?= $event->organiser->getImageUrl('small');?>"></a></div>
                <div class="info">
                  <a href="/event/view/time_id/<?= $event->times[0]->id;?>" title="<?= $event->current_contents->title;?>"><?= $event->current_contents->title;?></a>
                  <p class="about"><?= SiteHelper::russianDate($event->times[0]->date, false, false);?></p>
                  <? if ($event->organiser->web): ?><p class="link"><a href="<?= SiteHelper::linkify($event->organiser->web);?>" target="_blank"><?= $event->organiser->web; ?></a></p><? endif; ?>
                </div>
              </li>
            <? endforeach; ?>
          </ul>
        </div>