<div class="event-preview">
    <h2><a href="/event/view/time_id/<?= $data->id;?>" title="<?= $data->event->current_contents->title?>"><?= $data->event->current_contents->title?></a></h2>
    <p class="type"><?= $data->event->current_contents->section->title; ?></p>
    <dl>
    <? if (! $data->event->current_contents->is_free && $data->event->current_contents->price): ?>
        <dt>Цена:</dt>
        <dd><?= $data->event->current_contents->price ;?></dd>
    <? endif; ?>
        <dt>Когда:</dt>
        <dd>30 сентября</dd>
        <dt>Где:</dt>
        <dd><a href="#" title="кино в Планета кино">Планета кино</a></dd>
    </dl>
</div>