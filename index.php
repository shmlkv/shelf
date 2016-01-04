<!DOCTYPE html>
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
  <title>Главная</title>
  <link rel="stylesheet" href="css/main.css">
  <script type="text/javascript" src="http://userapi.com/js/api/openapi.js?34"></script>
</head>
<body>
<?php 
class Users {
  var $uid;
  var $fio;
  function setUID($par){
   $this->uid = $par;
  }
  function setFIO($par){
   $this->fio = $par;
  }
}
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
      $userobject = new Users;
      $userobject->setUID($_COOKIE['uid']);
      $userobject->setFIO($_COOKIE['first_name']." ". $_COOKIE['last_name']);
      array_push($usersjson->users, $userobject);
      fwrite(fopen('database/users.json', 'w'), json_encode($usersjson));

      $statsfile = file_get_contents("database/stats.json");
      $statsjson = json_decode($statsfile);
      $statsjson->users = $statsjson->users + 1;
      fwrite(fopen('database/stats.json', 'w'), json_encode($statsjson));
    }

    echo '<div class="header">
            <div class="wrap">
              <h1>Shelf</h1>
            </div>
          <div class="nav">
            <ul>
            <li><a href=""><img src="images/list.png" alt=""></a></li>
            <li><a href=""><img src="images/grid.png" alt=""></a></li>
            <li><a href="logout.php"><img src="images/exit.png" alt=""></a></li>
            </ul>
          </div>
         </div>';
    $file = file_get_contents("database/books.json");
    $json = json_decode($file);
    echo '<div class="wrap">';
    for($i = 0; $i <count($json->books); $i++){
      for($k = 0; $k<count($json->books[$i]->ids); $k++){
        if ($_COOKIE['uid'] == $json->books[$i]->ids[$k]){
          echo '<a href="book.php?book='.$json->books[$i]->id_book.'">';
          echo '<img src="covers/'.$json->books[$i]->cover.'" alt="">' ;
          echo $json->books[$i]->author;
          echo $json->books[$i]->title;
          echo'</a>';
        }
      }
    }
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
        VK.init({apiId: 5204968});
        VK.Widgets.Auth("vk_auth", {width: "300px",authUrl: '/login.php'});
    </script>
</div> 
</body>
</html>