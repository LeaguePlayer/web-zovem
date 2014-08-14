
    <div class="top-filter lk-nav">
        <div class="nav">
          <ul>
            <li><a href="#"><span>Ваш календарь</span></a></li>
            <li><a href="#"><span>Профиль</span></a></li>
            <li class="current"><a href="#"><span>Анонсы</span></a></li>
            <li><a href="#"><span>Шаблоны</span></a></li>
          </ul>
        </div>
      <div class="new-action">
        <a href="#" title="Добавить анонс">Добавить анонс</a>
      </div>

      
      <? $this->beginWidget('application.modules.hybridauth.components.ProfileWidget',array(
          'action' => $authAction ? $authAction : 'signin',
        ));
      $this->endWidget(); ?>

    </div>