<div class="top-filter lk-nav">
    <h1>Добавление статьи</h1>
    <div class="profile">
        <nobr class="overnobr"><a href="#" title="Профиль">Константин Константинопольский</a></nobr>
        <img src="./images/profile-photo.jpg">
    </div>
</div>

<div class="lk new-smth new-article">
    <div class="form">
        <form>
            <div class="form-fields">
                <p><input class="textinput" type="text" placeholder="Заголовок"></p>
                <p><textarea placeholder="Статья"></textarea></p>
                <p class="tags">
                    темы:
                    <input type="checkbox" name="tag1" id="tag1" checked="">
                    <label for="tag1">Детям</label>
                    <input type="checkbox" name="tag2" id="tag2" checked="">
                    <label for="tag2">Семейный</label>
                    <input type="checkbox" name="tag3" id="tag3">
                    <label for="tag3">Детям</label>
                    <input type="checkbox" name="tag4" id="tag4">
                    <label for="tag4">Семейный</label>
                </p>
                <div class="dropdown-link" role="dropdown-parent">
                    <a href="#" title="Выберите рубрику" role="dropdown-trigger">Рубрика</a>
                    <div class="noshadow" style="width: 130px;"></div>
                    <ul class="dropdown-list">
                        <li><a href="#">Туризм</a></li>
                        <li><a href="#">Концерты</a></li>
                        <li><a href="#">Арт-перспектива</a></li>
                    </ul>
                </div>
                <div class="dropdown-link" role="dropdown-parent">
                    <a href="#" title="Выберите город" role="dropdown-trigger">Город</a>
                    <div class="noshadow" style="width: 131px;"></div>
                    <ul class="dropdown-list">
                        <li><a href="#">Москва</a></li>
                        <li><a href="#">Санкт-Петербург</a></li>
                        <li><a href="#">Одесса-мама</a></li>
                    </ul>
                </div>
                <div class="bottom">
                    <div class="onoffswitch">
                        <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch">
                        <label class="onoffswitch-label" for="myonoffswitch">
                            <div class="onoffswitch-inner"></div>
                            <div class="onoffswitch-switch"></div>
                        </label>
                    </div>
                    <label for="myonoffswitch">Опубликовать анонимно</label>
                    <button type="submit">Добавить</button>
                </div>
            </div>
        </form>
    </div>
    <div class="additional">
        <div class="to-full-form">
            <a href="#"><span>Перейти к полной редакторской форме</span></a>
        </div>
    </div>
</div>