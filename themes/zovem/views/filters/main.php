
    <div class="top-filter">
      <div class="new-action">
        <a href="#" title="Создать мероприятие">мероприятие</a>
      </div>
      <div class="filter-box">
        <div class="tag-search" role="dropdown-parent">
          <a href="#" title="Поиск по темам" role="dropdown-trigger">
            <span class="icon"></span> Поиск по темам
          </a>
          <div class="noshadow"></div>
          <ul class="dropdown-list">
            <li><a href="#">Альпинизм</a></li>
            <li><a href="#">Концерты</a></li>
            <li><a href="#">Арт-фестивали</a></li>
            <li><a href="#">Кинопремьеры</a></li>
            <li><a href="#">Купить слона</a></li>
          </ul>
        </div>
        <div class="right">
          <div class="dates" role="dropdown-parent">
            <a href="#" title="Выберите дату" role="dropdown-trigger">Сегодня, сб 7 декабря</a>
            <div class="noshadow"></div>
            <ul class="dropdown-list">
              <li><a href="#">Сегодня, сб 7 декабря</a></li>
              <li><a href="#">Завтра, вс 8 декабря</a></li>
              <li><a href="#">На следующей неделе</a></li>
            </ul>
          </div>
          <div class="action-types" role="dropdown-parent">
            <a href="#" title="Выберите рубрику" role="dropdown-trigger">
              По разделам
            </a>
            <div class="noshadow"></div>
            <ul class="dropdown-list">
              <li><a href="#">Киносеансы</a></li>
              <li><a href="#">Ярмарки</a></li>
              <li><a href="#">Концерты</a></li>
              <li><a href="#">Путешествия</a></li>
            </ul>
          </div>
        </div>
      </div>

      <? $this->beginWidget('application.modules.hybridauth.components.ProfileWidget',array(
          'action' => $authAction ? $authAction : 'signin',
        ));
      $this->endWidget(); ?>

    </div>