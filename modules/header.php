<?php
if (isset($_COOKIE['log'])) {
    echo '<header>
            <div class="wrap">
                <div class="nav">
                  <ul class="left">
                    <li class="bold"><a href="/">Shelf</a></li>
                    <li class="active"><a href="/">Моя полка</a></li>
                    <li><a href="/users.php">Пользователи</a></li>
                    <li><a href="/book.php">Книги</a></li>
                    <li><a href="/celebrities.php">Знаменитости</a></li>
                  </ul>
                  <ul class="right">
                    <li class="bold blue"><a href="#addbook">Добавить книгу</a></li>
                    <li><a href="/profile.php">Профиль</a></li>
                    <li><a href="logout.php">Выход</a></li> 
                  </ul>
                </div>
            </div>
         </header>';
  }else{
  echo '<header>
           <div class="wrap">
               <div class="nav">
                 <ul class="left">
                   <li class="bold"><a href="">Shelf</a></li>
                   <li><a href="">Пользователи</a></li>
                   <li><a href="">Книги</a></li>
                   <li><a href="">Знаменитости</a></li>
                 </ul>
                 <ul class="right">
                    <li class="bold blue"><a href="">VK Войти</a></li> 
                 </ul>
               </div>
           </div>
        </header>';
  }
?>