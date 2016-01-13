<!DOCTYPE html>
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
  <title>Книга</title>
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/foundation.min.css">
  <link rel="stylesheet" href="css/foundstiling.css">
  <script type="text/javascript" src="http://userapi.com/js/api/openapi.js?34"></script>  
</head>
<body>
<?php
  include 'modules/header.php';
  if (isset($_COOKIE['log'])) {
    $booksfile = file_get_contents("database/books.json");
    $booksjson = json_decode($booksfile);

    $usersfile = file_get_contents("database/users.json");
    $usersjson = json_decode($usersfile);

    echo '<div id="content">';
      echo '<div class="wrap">';
    if(empty($_GET['book'])){
      for($i = 1; $i <count($booksjson->books); $i++){
        echo '<div class="book-block">';
            echo '<a href="book.php?book=',$booksjson->books[$i]->id,'">';
              echo '<img src="',$booksjson->books[$i]->cover,'" alt="">';
              echo '<span class="title">',$booksjson->books[$i]->title,'</span>';
              echo '<span class="author">',$booksjson->books[$i]->author,  '</span>';
            echo'</a>';
        echo '</div>';
      }
    }else{
      for($k = 0; $k<count($booksjson->books); $k++){
        if ($_GET['book'] == $booksjson->books[$k]->id){
          echo '<div class="book-img">
                  <img class="book-img" src="'.$booksjson->books[$k]->cover.'" alt="">
                </div>';
          echo '<div class="book-info">
                  <div class="block">
                    <span class="title">'.$booksjson->books[$k]->title.'</span>
                    <span class="author">'.$booksjson->books[$k]->author.'</span>
                  </div>
                  <div class="block">
                    <a title="Прочитавшие" href="" class="btn inline addbook"><span class="icon-people"></span> '.count($booksjson->books[$k]->readers).'</a>
                    <a title="Желающие прочитать" href="" class="btn inline addbook"><span class="icon-bookmarks"></span> '.count($booksjson->books[$k]->toread).'</a>
                    <a title="Рейтинг" href="" class="btn inline addbook"><span class="icon-stats-bars"></span> '.$booksjson->books[$k]->averagerating.'</a>
                  </div>';
                  if($booksjson->books[$k]->desc){
                    echo '<div class="block">
                            <span class="bold inline">Описание:</span>
                            <p>'.$booksjson->books[$k]->desc.'</p>
                          </div>';
                  }
                  $idreadedbook = false;
                  for($i = 0; $i<count($booksjson->books[$k]->readers); $i++){
                      if($_COOKIE['uid'] === $booksjson->books[$k]->readers[$i]->uid){
                        $idreadedbook = true;
                        $mybookrate = $booksjson->books[$k]->readers[$i]->rating;
                      }
                  }

                  if(!$idreadedbook){
                    if (in_array($_COOKIE['uid'], $booksjson->books[$k]->toread)) {
                      echo '<p><a title="Прочитал" class="btn" href="#addthisbook" class="addbook"><span class="icon-book"></span> Прочитал</a>';
                      echo '<a title="Не хочу читать" class="btn" href="scripts/toread.php?book='.$booksjson->books[$k]->id.'" class="addbook"><span class="icon-heart-broken"></span>Не хочу читать</a></p>';
                    }else{
                      echo '<p><a title="Прочитал" class="btn" href="#addthisbook" class="addbook"><span class="icon-book"></span>Прочитал</a>';
                      echo '<a title="Хочу прочитать" class="btn" href="scripts/toread.php?book='.$booksjson->books[$k]->id.'" class="addbook"><span class="icon-heart"></span>Хочу прочитать</a></p>';
                    }
                  }else{
                     echo '<a class="btn" href="" class="addbook"><span class="icon-book"></span>Вы читали эту книгу, ваша оценка <span class="bold">'.$mybookrate.'</span></a>';
                  }
          echo '</div>';

          echo '<div id="comments">
                <div class="block">
                <info>Коментарии</info>
                </div>';
                  for($a = 0; $a<count($booksjson->books[$k]->readers); $a++){
                      for($l = 0; $l<count($usersjson->users); $l++){
                        if($usersjson->users[$l]->uid == $booksjson->books[$k]->readers[$a]->uid){
                          $userObj = $usersjson->users[$l];
                        }
                      }
                      if($booksjson->books[$k]->readers[$a]->comment){
                        echo '<div class="comment">
                            <img src="'.$userObj->pic.'" alt="">
                            <div class="comment-head">
                              <a class="comment-head-name" href="users.php?user='.$userObj->uid.'" class="dontdecorate">'.$userObj->fio.'</a>
                              <date>'.$booksjson->books[$k]->readers[$a]->date.'</date>
                              <div class="comment-head-rating"><span class="icon-thumbs-up"></span> '.$booksjson->books[$k]->readers[$a]->commentrating.' <span class="icon-thumbs-down"></span></div>
                            </div>
                            <div class="comment-text">
                              <p>'.$booksjson->books[$k]->readers[$a]->comment.'</p>
                            </div>
                          </div>';
                      }
                  }
            echo '</div>';
          
        }
      }
    }
    echo'</div>';
     echo'</div>';
     include 'modules/footer.php';
     include 'modules/popup.php';
   }
?>
    <script type="text/javascript">
        VK.init({apiId: 5197194}); //второй
        VK.Widgets.Auth("vk_auth", {width: "300px",authUrl: '/login.php'});
    </script>
</div> 
</body>
</html>