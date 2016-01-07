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

    echo '<div id="content">';
      echo '<div class="wrap">';
    if(empty($_GET['book'])){
      echo 'List of books';
    }else{
      for($k = 0; $k<count($booksjson->books); $k++){
        if ($_GET['book'] == $booksjson->books[$k]->id_book){
          echo '<div class="book-img">
                  <img class="book-img" src="'.$booksjson->books[$k]->cover.'" alt="">
                  <div class="rating"></div>
                </div>';
          echo '<div class="book-info">
                  <h2>'.$booksjson->books[$k]->title.'</h2>
                  <h3>'.$booksjson->books[$k]->author.'</h3>
                  <p>'.$booksjson->books[$k]->id_book.'</p>
                  <p>'.$booksjson->books[$k]->desc.'</p>
                  <div id="comments">';
                  for($a = 0; $a<count($booksjson->books[$k]->coments); $a++){
                    echo '<div class="comment">
                            <img src="covers/дары.jpg" alt="">
                            <div class="comment-text"><p>'.$booksjson->books[$k]->coments[$a]->userid.'</p>'.$booksjson->books[$k]->coments[$a]->comment.'</div>
                          </div>';
                  }
            echo '</div>';
          echo '</div>';
          
        }
      }
    }
    echo'</div>';
     echo'</div>';
  }else{
    echo '<div class="window">
              <h2>Здравствуй</h2>
            <div class="wrap">
              <div id="vk_auth"></div>
            </div>
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