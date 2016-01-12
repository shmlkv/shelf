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
              echo '<span class="title">',$booksjson->books[$i]->title,'</span>';
              echo '<span class="author">',$booksjson->books[$i]->author,  '</span>';
              echo '<img src="',$booksjson->books[$i]->cover,'" alt="">';
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
                  <h2>'.$booksjson->books[$k]->title.'</h2>
                  <h3>'.$booksjson->books[$k]->author.'</h3>
                  <p>'.$booksjson->books[$k]->desc.'</p>
                  <p>Людей прочитало книгу: '.count($booksjson->books[$k]->readers).'</p>
                  <p>Людей хотят прочитать книгу: '.count($booksjson->books[$k]->toread).'</p>
                  <p>Cредний рейтинг: '.$booksjson->books[$k]->averagerating.'</p>';
                  $idreadedbook = false;
                  for($i = 0; $i<count($booksjson->books[$k]->readers[$i]); $i++){
                      if($_COOKIE['uid'] === $booksjson->books[$k]->readers[$i]->uid){
                        $idreadedbook = true;
                      }
                  }

                  if(!$idreadedbook){
                    if (in_array($_COOKIE['uid'], $booksjson->books[$k]->toread)) {
                      echo '<p><a href="#addthisbook" class="addbook">[+] Прочитал</a></p>';
                      echo '<p><a href="scripts/toread.php?book='.$booksjson->books[$k]->id.'" class="addbook">[х] Не хочу прочитать</a></p>';
                    }else{
                      echo '<p><a href="#addthisbook" class="addbook">[+] Прочитал</a></p>';
                      echo '<p><a href="scripts/toread.php?book='.$booksjson->books[$k]->id.'" class="addbook">[+] Хочу прочитать</a></p>';
                    }
                  }else{
                     echo '<p><a href="" class="addbook">Вы читали эту книгу</a></p>';
                  }

                  echo '<div id="comments">';
                  for($a = 0; $a<count($booksjson->books[$k]->comments); $a++){
                    for($l = 0; $l<count($usersjson->users); $l++){
                      if($usersjson->users[$l]->uid == $booksjson->books[$k]->comments[$a]->uid){
                        $userObj = $usersjson->users[$l];
                      }
                    }
                    echo '<div class="comment">
                            <img src="'.$userObj->pic.'" alt="">
                            <div class="comment-head">
                              <h4>'.$userObj->fio.'</h4>
                              <div class="comment-head-rating"><span class="icon-thumbs-up"></span> '.$booksjson->books[$k]->comments[$a]->rating.' <span class="icon-thumbs-down"></span></div>
                            </div>
                            <div class="comment-text">
                              <p>'.$booksjson->books[$k]->comments[$a]->comment.'</p>
                            </div>
                          </div>';
                  }
            echo '</div>';
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