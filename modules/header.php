<?php
echo '<header>
        <div class="wrap">
          <div class="nav">
            <ul class="left">
              <li class="bold"><a href=""><span class="icon-books"></span>Книжная полка</a></li>
              <li><a href="">Пользователи</a></li>
              <li><a href="">Книги</a></li>
              <li><a href="celebrities.php">Знаменитости</a></li>
            </ul>';
if (isset($_COOKIE['log'])) {
      echo '<ul class="right">
              <li class="bold blue"><a href="#" data-popup-open="popup-addbook"><span class="icon-plus"></span>Добавить книгу</a></li>
              <li><a href="users.php?user='.$_COOKIE['uid'].'"><span class="icon-user"></span>Профиль</a></li>
              <li><a href="logout.php"><span class="icon-exit"></span>Выход</a></li> 
            </ul>';
  }else{
      echo '<ul class="right">
              <li class="bold blue"><a href=""><span class="icon-vk"></span> Войти</a></li> 
            </ul>';
  }
  echo '</div>
      </div>
    </header>'
?>