<?php
if (isset($_COOKIE['log'])) {
    echo '<header>
            <div class="wrap">
                <div class="nav">
                  <ul class="left">
                    <li class="logo"><a href="">Shelf</a></li>
                    <li class="active"><a href="">Моя полка</a></li>
                    <li><a href="">Пользователи</a></li>
                    <li><a href="">Книги</a></li>
                    <li><a href="">Знаменитости</a></li>
                  </ul>
                  <ul class="right">
                    <li><a href="">Добавить книгу</a></li>
                    <li><a href="">Профиль</a></li>
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
                   <li class="logo"><a href="">Shelf</a></li>
                   <li><a href="">Пользователи</a></li>
                   <li><a href="">Книги</a></li>
                   <li><a href="">Знаменитости</a></li>
                 </ul>
                 <ul class="right">
                    <li><a href="">VK Войти</a></li> 
                  </ul>
               </div>
           </div>
        </header>';
         }
         ?>