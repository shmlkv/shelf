<!DOCTYPE html>
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
  <title>Главная</title>
  <link rel="stylesheet" href="css/main.css">
  <script type="text/javascript" src="http://userapi.com/js/api/openapi.js?34"></script>
</head>
<body>
<?php 
  $userexist=false;
  if (isset($_COOKIE['log'])) {
    $usersfile = file_get_contents("database/users.json");
    $jsonusersfile = json_decode($usersfile);

    for($p = 0; $p <count($jsonusersfile->users); $p++){
      echo $_COOKIE['uid'];
      echo $jsonusersfile->users[$p]->userid;
      if ($_COOKIE['uid'] == $jsonusersfile->users[$p]->userid){
        $userexist=true;
      }
    }
    if(!$userexist){
      $obj->id = $_COOKIE['uid'];
      $obj->fio= $_COOKIE['first_name']. $_COOKIE['last_name'];
      array_push($jsonusersfile['users'],$obj);
      echo $obj;
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
    echo $obj->id = $_COOKIE['uid'];
    $file = file_get_contents("database/books.json");
    $json = json_decode($file);

    echo '<div class="wrap">';
    for($i = 0; $i <count($json->books); $i++){
      for($k = 0; $k<count($json->books[$i]->ids); $k++){
        if ($_COOKIE['uid'] == $json->books[$i]->ids[$k]){
          echo'<a href="book.php?book='.$json->books[$i]->id_book.'">';
          echo '<img src="cover/'.$json->books[$i]->cover.'" alt="">' ;
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
        VK.init({apiId: 5197194});
        VK.Widgets.Auth("vk_auth", {width: "300px",authUrl: '/login.php'});
    </script>
</div> 
</body>
</html>