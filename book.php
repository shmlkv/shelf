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
  if (isset($_COOKIE['log'])) {
    echo '<header>
            <div class="wrap">
                <div class="nav">
                  <ul class="left">
                    <li class="logo"><a href="">Shelf</a></li>
                    <li><a href="">Моя полка</a></li>
                    <li><a href="">Пользователи</a></li>
                    <li><a href="">Книги</a></li>
                    <li><a href="">Знаменитости</a></li>
                  </ul>
                  <ul class="right">
                    <li><a href="">Профиль</a></li>
                    <li><a href="logout.php">Выход</li> 
                  </ul>
                </div>
            </div>
         </header>';
    $booksfile = file_get_contents("database/books.json");
    $booksjson = json_decode($booksfile);

    echo '<div id="content">';
      echo '<div class="wrap">';
    if(empty($_GET['book'])){
      echo 'Error';
    }else{
      for($k = 0; $k<count($booksjson->books); $k++){
        if ($_GET['book'] == $booksjson->books[$k]->id_book){
          
          echo '<div class="block">';
            echo '<img src="covers/'.$booksjson->books[$k]->cover.'" alt="">' ;
            echo $booksjson->books[$k]->author;
            echo $booksjson->books[$k]->title;
          echo '</div>';
          echo '<div class="block-info">';
          echo $booksjson->books[$k]->id_book;  
          for($a = 0; $a<count($booksjson->books[$k]->coments); $a++){
            echo '<div>';
            
            echo $booksjson->books[$k]->coments[$a]->userid;
            echo $booksjson->books[$k]->coments[$a]->comment;
            echo '</div>';
          }
          echo '</div>';
          
        }
      }
    }
    echo'</div>';
     echo'</div>';
  }else{
    echo '<div class="header">
            <div class="wrap">
              <h1>Shelf</h1>
            </div>
            <div class="nav">
           
            </div>
          </div>
          <div class="window">
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