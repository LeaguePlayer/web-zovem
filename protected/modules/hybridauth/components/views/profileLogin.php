      <div class="login">
        <a href="#" role="login-toggle">Войти</a>
        <div class="form" role="closeable">
          <a href="#" class="close" role="close"></a>
          <a href="#" class="signin<? if($action == 'signin'): ;?> current<? endif; ?>">Войти</a> 
          <a href="#" class="signup<? if($action == 'signup'): ;?> current<? endif; ?>">Зарегистрироваться</a>
          <form class="signin-form" action="" <? if($action !== 'signin'): ;?>hidden<? endif; ?>>
            <p><input type="email" class="textinput" placeholder="Электронная почта"></p>
            <p><input type="password" class="textinput" placeholder="Пароль"></p>
            <p><button type="submit" class="button">Войти</button></p>
          </form>
          <form class="signup-form" action="" <? if($action !== 'signup'): ;?>hidden<? endif; ?>>
            <p><input type="email" class="textinput" placeholder="Электронная почта"></p>
            <p><input type="text" class="textinput" placeholder="Имя"></p>
            <p><input type="text" class="textinput" placeholder="Фамилия"></p>
            <p><input type="password" class="textinput" placeholder="Пароль"></p>
            <p><input type="password" class="textinput" placeholder="Пароль ещё раз"></p>
            <p><button type="submit" class="button">Войти</button></p>
          </form>
          <div class="social">
            <p>Войдите через социальные сети:</p>
            <?php $this->widget('application.modules.hybridauth.widgets.renderProviders'); ?>
          </div>
        </div>
      </div>