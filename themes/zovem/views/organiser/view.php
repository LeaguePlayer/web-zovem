
    <div class="organazer">
      <h1><? if($organazer->img_image): ?><img src="<?= $organiser->getImageUrl('small');?>" alt="<?= $organiser->title;?>"><? endif; ?><?= $organiser->title;?></h1>
      <div class="info">
        <div class="content">
        	<?= $organiser->text; ?>
        </div>
        <div class="contacts">
          <p><?= $organiser->city->title .', ' .$organiser->address;?></p>
          <? if ($organiser->web): ?><p><a href="<?= SiteHelper::linkify($organiser->web) ;?>" target="_blank"><?= $organiser->web;?></a></p><? endif;?> 
        </div>
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
            <a href="#" class="comments">14</a>
            <a href="#" class="likes">120</a>
          </div>
        </div>
        <? $this->widget('widgets.comment.CommentsWidget', array(
            'type' => OrganiserComment::TYPE_OF_COMMENT,
            'material_id' => $organiser->id
        )) ?>
      </div>
      <div class="right-bar">

      <? if (!empty($upcoming)):?>
        <h2>Этот устроитель
представляет:</h2>
        <ul>
          <? foreach($upcoming as $time): ?>
          <li>
            <a href="/event/view/time_id/<?= $time->id; ?>" title="<?= $time->event->current_contents->title;?>"><?= $time->event->current_contents->title;?></a>
            <span class="date"><?= SiteHelper::russianDate($time->date, false, false); ?></span>
          </li>
          <? endforeach; ?>
        </ul>
      <? endif; ?>

      <? if (!empty($archived)):?>
        <h2 class="title"><span>Прошедшие анонсы</span></h2>
        <ul>
          <? foreach($archived as $time): ?>
          <li>
            <a href="/event/view/time_id/<?= $time->id; ?>" title="<?= $time->event->current_contents->title;?>"><?= $time->event->current_contents->title;?></a>
            <span class="date"><?= SiteHelper::russianDate($time->date, false, false); ?></span>
          </li>
          <? endforeach; ?>
        </ul>
      <? endif; ?>

        <? if (!empty($articles)): ?>
        <h2>Статьи этого устранителя:</h2>
        <ul>
        <? foreach($articles as $article): ?>
          <li>
            <a href="/article/view/id/<?= $article->id;?>"><?= $article->title;?></a>
          </li>
        <? endforeach; ?>
        </ul>
    	<? endif; ?>

      </div>
    </div>