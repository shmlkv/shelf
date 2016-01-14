<!DOCTYPE html>
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
  <title>Главная</title>
  <link rel="stylesheet" href="css/main.css">
  <script type="text/javascript" src="http://userapi.com/js/api/openapi.js?34"></script>
</head>
<body>
<?php
  include 'modules/header.php';

  $userexist=false;
  if (isset($_COOKIE['log'])) {
    $usersfile = file_get_contents("database/users.json");
    $usersjson = json_decode($usersfile);
    for($i = 0; $i <count($usersjson->users); $i++){
      if ($_COOKIE['uid'] === $usersjson->users[$i]->uid){
        $userexist=true;
      }
    }
    
    if(!$userexist){
      $userobject = array('uid' => $_COOKIE['uid'], 'fio' => $_COOKIE['first_name']." ". $_COOKIE['last_name'], 'pic' => $_COOKIE['photo'], 'rating' => '0');
      array_push($usersjson->users, $userobject);
      fwrite(fopen('database/users.json', 'w'), json_encode($usersjson, JSON_PRETTY_PRINT, JSON_UNESCAPED_UNICODE));

      $statsfile = file_get_contents("database/stats.json");
      $statsjson = json_decode($statsfile);
      $statsjson->users = count($usersjson->users);
      fwrite(fopen('database/stats.json', 'w'), json_encode($statsjson, JSON_PRETTY_PRINT, JSON_UNESCAPED_UNICODE));
    }
    
    $file = file_get_contents("database/books.json");
    $json = json_decode($file);
    echo '<div id="content">
            <div class="wrap">';
            echo '<div class="wantto">
            <info style="margin-bottom: 20px">Хотите прочитать</info>';
        for($i = 0; $i <count($json->books); $i++){
          for($k = 0; $k<count($json->books[$i]->toread); $k++){
            if ($_COOKIE['uid'] == $json->books[$i]->toread[$k]){
              echo '<div class="book-block">';
                  echo '<a href="book.php?book=',$json->books[$i]->id,'">';
                    echo '<img src="',$json->books[$i]->cover,'" alt="">';
                    echo '<span class="title">',$json->books[$i]->title,'</span>';
                    echo '<span class="author">',$json->books[$i]->author,  '</span>';
                  echo'</a>';
              echo '</div>';
            }
          }
        }
        echo '</div>';
        echo '<info style="margin-bottom: 20px">Прочитали</info>';
        for($i = 0; $i <count($json->books); $i++){
          for($k = 0; $k<count($json->books[$i]->readers); $k++){
            if ($_COOKIE['uid'] == $json->books[$i]->readers[$k]->uid){
              echo '<div class="book-block">';
                  echo '<a href="book.php?book=',$json->books[$i]->id,'">';
                    echo '<img src="',$json->books[$i]->cover,'" alt="">';
                    echo '<span class="title">',$json->books[$i]->title,'</span>';
                    echo '<span class="author">',$json->books[$i]->author,  '</span>';
                  echo'</a>';
              echo '</div>';
            }
          }
        }
      echo '</div>
        </div>';
    include 'modules/popup.php';
  }else{
    echo '<div id="content">
            <div class="wrap">
            <h1 class="text-center">Здравствуй!</h1>
            <div style="margin:10px auto" id="vk_auth"></div>
            </div>
          </div>';
    echo '<script type="text/javascript">
            VK.init({apiId: 5204968});
            VK.Widgets.Auth("vk_auth", {width: "300px",authUrl: "login.php"});
          </script>';
  } 
  
  include 'modules/footer.php';
?>
<script src="scripts/main.js"></script>
</div> 
</body>
</html>