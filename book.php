<?php session_start(); ?>
<!DOCTYPE html>
<?php
  $booksfile = file_get_contents("database/books.json");
  $booksjson = json_decode($booksfile);
  if (isset($_GET['book'])){
    $title = $booksjson->books[$_GET['book']]->title;
  }else{
    $title = 'Все книги';
  }
?>
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
  <title><?=$title?></title>
  <link rel="stylesheet" href="css/main.css">
  <script type="text/javascript" src="http://userapi.com/js/api/openapi.js?34"></script>  
</head>
<body>
<?php
  include 'modules/header.php';
  $usersfile = file_get_contents("database/users.json");
  $usersjson = json_decode($usersfile);
  echo '<div id="content">';
    echo '<div class="wrap">';
  if(empty($_GET['book'])){
    array_splice($booksjson->books, 0, 1);
    usort($booksjson->books, function($a, $b){
      return ($b->averagerating - $a->averagerating);
    });
    for($i = 0; $i <count($booksjson->books); $i++){
      echo '<div class="book-block">';
          echo '<a href="book.php?book=',$booksjson->books[$i]->id,'">';
            echo '<img src="',$booksjson->books[$i]->cover,'" alt="">';
            echo '<mark>'.$booksjson->books[$i]->averagerating.'</mark>';
            echo '<span class="title">',$booksjson->books[$i]->title,'</span>';
            echo '<span class="author">',$booksjson->books[$i]->author, '</span>';
          echo'</a>';
      echo '</div>';
    }
  }else{
  for($k = 1; $k<count($booksjson->books); $k++){
    if ($_GET['book'] == $booksjson->books[$k]->id){
      $title = $booksjson->books[$k]->title;
      echo '<div class="book-img">
              <img class="book-img" src="'.$booksjson->books[$k]->cover.'" alt="">
            </div>';
      echo '<div class="book-info">
              <div class="block">
                <span class="title">'.$booksjson->books[$k]->title.'</span>
                <span class="author">'.$booksjson->books[$k]->author.'</span>
              </div>
              <div class="block">
                <a title="Прочитавшие книгу" href="" class="btn inline addbook"><span class="icon-people"></span>Прочитало: <b>'.count($booksjson->books[$k]->readers).'</b></a>
                <a title="Желающие прочитать" href="" class="btn inline addbook"><span class="icon-bookmarks"></span>Желают прочитать: <b>'.count($booksjson->books[$k]->toread).'</b></a>
                <a title="Рейтинг" href="" class="btn inline addbook"><span class="icon-stats-bars"></span>Рейтинг: <b>'.$booksjson->books[$k]->averagerating.'</b></a>
              </div>';
              if($booksjson->books[$k]->desc){
                echo '<div class="block">
                        <span class="bold inline">Описание:</span>
                        <p';
                if (($_COOKIE['uid'] == '121935185') || ($_COOKIE['uid'] == '151805674')){
                  echo ' contenteditable="plaintext-only" id="editor">';
                }
                echo $booksjson->books[$k]->desc.'</p></div>';
                if(($_COOKIE['uid'] == '121935185') || ($_COOKIE['uid'] == '151805674')){
                  echo '<button class="btn inline addbook" id="save" style="display:block !important" value="'.$_GET['book'].'">Save description</button>';
                }
              }elseif((($_COOKIE['uid'] == '121935185') || ($_COOKIE['uid'] == '151805674')) && empty($booksjson->books[$k]->desc)){
               echo '<div class="block">
                        <span class="bold inline">Описание:</span>
                        <p contenteditable="plaintext-only" id="editor" >Пусто(ну так добавь)</p></div>
                        <button class="btn inline addbook" id="save" style="display:block !important" value="'.$_GET['book'].'">Save description</button>';
              }
                $idreadedbook = false;
              for($i = 0; $i<count($booksjson->books[$k]->readers); $i++){
                  if($_COOKIE['uid'] === $booksjson->books[$k]->readers[$i]->uid){
                    $idreadedbook = true;
                    $mybookrate = $booksjson->books[$k]->readers[$i]->rating;
                  }
              }
              if(!$idreadedbook){
                if (in_array($_COOKIE['uid'], $booksjson->books[$k]->toread)){
                  echo '<p><button title="Прочитал" class="btn addbook" href="#" data-popup-open="popup-addthisbook"><span class="icon-book"></span> Прочитал</button>';
                  echo '<button id="fav" value="'.$booksjson->books[$k]->id.'" title="Не хочу читать" class="btn addbook"><span class="icon-heart-broken"></span>Не хочу читать</button></p>';
                }elseif(!isset($_COOKIE['log'])){
                  echo '<p><button disabled="disabled" title="Прочитал" class="btn addbook" href="#" data-popup-open="popup-addthisbook"><span class="icon-book"></span>Прочитал</button>';
                  echo '<button disabled="disabled" id="fav" value="'.$booksjson->books[$k]->id.'" title="Хочу прочитать" class="btn addbook"><span class="icon-heart"></span>Хочу прочитать</button></p>';
                }else{
                  echo '<p><button title="Прочитал" class="btn addbook" href="#" data-popup-open="popup-addthisbook"><span class="icon-book"></span>Прочитал</button>';
                  echo '<button id="fav" value="'.$booksjson->books[$k]->id.'" title="Хочу прочитать" class="btn addbook"><span class="icon-heart"></span>Хочу прочитать</button></p>';
                }
              }else{
                 echo '<a class="btn" href="" class="addbook"><span class="icon-book"></span>Вы читали эту книгу, ваша оценка <span class="bold">'.$mybookrate.'</span></a>
                 <a href="scripts/addbook.php?bookid='.$booksjson->books[$k]->id.'&delete=true" title="Удалить" class="delete-book btn">X</a>';
              }
              
      echo '</div>';
      echo '<div id="comments">
            <div class="block">
            <info>Коментарии</info>
            </div>';
             $nocomments = true;
              for($a = 0; $a<count($booksjson->books[$k]->readers); $a++){
                  for($l = 0; $l<count($usersjson->users); $l++){
                    if($usersjson->users[$l]->uid == $booksjson->books[$k]->readers[$a]->uid){
                      $userObj = $usersjson->users[$l];
                    }
                  }
                  if($booksjson->books[$k]->readers[$a]->comment){
                     $nocomments = false;
                    echo '<div class="comment" value="'.$userObj->uid.'">
                        <img src="'.$userObj->pic.'" alt="">
                        <div class="comment-head">
                          <a class="comment-head-name" href="users.php?user='.$userObj->uid.'" class="dontdecorate">'.$userObj->fio.'</a>
                          <date>'.date_format(date_create($booksjson->books[$k]->readers[$a]->date), "d.m.Y").'</date>
                          <div class="comment-head-rating"><span class="icon-thumbs-up opinion" id="like"></span> '.$booksjson->books[$k]->readers[$a]->commentrating.' <span class="icon-thumbs-down opinion" id="dislike"></span></div>
                        </div>
                        <div class="comment-text">
                          <p>'.$booksjson->books[$k]->readers[$a]->comment.'</p>
                        </div>
                      </div>';
                  }
              }
              if($nocomments){
                echo 'Тут ещё нет комментариев';
              }
        echo '</div>';
      
    }
  }
    
   }
   echo'</div>';
     echo'</div>';
     include 'modules/footer.php';
     include 'modules/popup.php';
?>
    <script type="text/javascript">
        VK.init({apiId: 5197194}); //второй
        VK.Widgets.Auth("vk_auth", {width: "300px",authUrl: '/login.php'});
    </script>
</div>
<script src="scripts/main.js"></script>
</body>
</html>