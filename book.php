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
      echo 'List of books';
    }else{
      for($k = 0; $k<count($booksjson->books); $k++){
        if ($_GET['book'] == $booksjson->books[$k]->id){
          echo '<div class="book-img">
                  <img class="book-img" src="'.$booksjson->books[$k]->cover.'" alt="">
                  <div class="rating"></div>
                </div>';
          echo '<div class="book-info">
                  <h2>'.$booksjson->books[$k]->title.'</h2>
                  <h3>'.$booksjson->books[$k]->author.'</h3>
                  <p>'.$booksjson->books[$k]->id.'</p>
                  <p>'.$booksjson->books[$k]->desc.'</p>
                  <div id="comments">';
                  for($a = 0; $a<count($booksjson->books[$k]->comments); $a++){
                    for($l = 0; $l<count($usersjson->users); $l++){
                      if($usersjson->users[$l]->uid == $booksjson->books[$k]->comments[$a]->uid){
                        $commentfio = $usersjson->users[$l]->fio;
                        $commentpic =$usersjson->users[$l]->pic;
                      }
                    }
                    echo '<div class="comment">
                            <img src="'.$commentpic.'" alt="">
                            <div class="comment-head">
                              <h4>'.$commentfio.'</h4>
                              <div class="comment-head-rating">↑ '.$booksjson->books[$k]->comments[$a]->rating.' ↓</div>
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
  }else{
    echo '<div id="content">';
        echo '<div class="wrap">';
        echo '<h1 class="text-center">Здравствуй!</h1>';
        echo '<div style="margin:10px auto" id="vk_auth"></div>';
        echo '</div>
            </div>';
  }
?>
    <script type="text/javascript">
        VK.init({apiId: 5197194}); //второй
        VK.Widgets.Auth("vk_auth", {width: "300px",authUrl: '/login.php'});
    </script>
</div> 
</body>
</html>