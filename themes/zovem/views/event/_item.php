
<div class="item<? if($data->event->current_contents->is_free):?> for-free<? endif; ?>">
  <h2><a href="/event/view/time_id/<?= $data->id;?>" title="<?= $data->event->current_contents->title;?>"><?= $data->event->current_contents->title;?></a><span><img src="<?= $data->event->current_contents->section->getImageUrl();?>" alt="<?= $data->event->current_contents->section->title;?>"></span></h2>
  <span class="date"><?= SiteHelper::russianDate($data->start_datetime, false, true);?></span>
  <p class="preview"><?= $data->event->current_contents->city->title .', ' .$data->event->current_contents->address;?></p>
  <div class="misc">
    <p class="tags">
      <a href="#" title="тэг Детям">Детям</a>
      <a href="#" title="тэг Семейный">Семейный</a>
    </p>
    <p class="lcomments">
      <a href="#" class="comments" title="Комментарии">14</a>
      <a href="#" class="likes liked" title="Нравится">120</a>
    </p>
  </div>
</div>