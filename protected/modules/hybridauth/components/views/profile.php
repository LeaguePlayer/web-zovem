<div class="profile" role="dropdown-parent">
	<nobr><a href="#" title="Профиль" role="dropdown-trigger"><?= $user->getFullName();?></a></nobr>
	<div class="noshadow" style="display: none; width: 92px;"></div>
	<ul class="dropdown-list" style="display: none;">
	  <li><a href="/user/profile/">Профиль</a></li>
	  <li><a href="#">Избранное</a></li>
	  <li><a href="/user/logout/">Выйти</a></li>
	</ul>
	<img src="<?= $user->profile->img_photo;?>">
</div>