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
      $userobject = array('uid' => $_COOKIE['uid'], 'fio' => $_COOKIE['first_name']." ". $_COOKIE['last_name'], 'pic' => $_COOKIE['photo']);
      array_push($usersjson->users, $userobject);
      fwrite(fopen('database/users.json', 'w'), json_encode($usersjson, JSON_PRETTY_PRINT, JSON_UNESCAPED_UNICODE));

      $statsfile = file_get_contents("database/stats.json");
      $statsjson = json_decode($statsfile);
      $statsjson->users = $statsjson->users + 1;
      fwrite(fopen('database/stats.json', 'w'), json_encode($statsjson, JSON_PRETTY_PRINT, JSON_UNESCAPED_UNICODE));
    }
    
         //<img src="images/exit.png" alt="">exit</a>
    $file = file_get_contents("database/books.json");
    $json = json_decode($file);
    echo '<div id="content">';
      echo '<div class="wrap">';
        for($i = 0; $i <count($json->books); $i++){
          for($k = 0; $k<count($json->books[$i]->readed); $k++){
            if ($_COOKIE['uid'] == $json->books[$i]->readed[$k]){
              echo '<div class="book-block">';
                  echo '<a href="book.php?book=',$json->books[$i]->id,'">';
                  echo '<span class="title">',$json->books[$i]->title,'</span>';
                  echo '<span class="author">',$json->books[$i]->author,  '</span>';
                  echo '<img src="',$json->books[$i]->cover,'" alt="">';
                echo'</a>';
              echo '</div>';
            }
          }
        }
      echo '</div>';
    echo '</div>';
  }else{
   echo '<div id="content">';
        echo '<div class="wrap">';
        echo '<h1 class="text-center">Здравствуй!</h1>';
        echo '<div style="margin:10px auto" id="vk_auth"></div>';
        echo '</div>
            </div>';
  echo '<script type="text/javascript">
        VK.init({apiId: 5204968});
        VK.Widgets.Auth("vk_auth", {width: "300px",authUrl: "/login.php"});
    </script>';
  } 
  include 'modules/popup.php';
  include 'modules/footer.php';
?>
    
</div> 
</body>
</html>