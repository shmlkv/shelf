<!DOCTYPE html>
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
  <title>Пользователи</title>
  <link rel="stylesheet" href="css/main.css">
  <script type="text/javascript" src="http://userapi.com/js/api/openapi.js?34"></script>
</head>
<body>
<?php
  $usersfile = file_get_contents("database/users.json");
  $usersjson = json_decode($usersfile);
	include 'modules/header.php';
  if(($_GET['user'])){
      echo 'user info';
    }else{
	echo '<div id="content">';
      echo '<div class="wrap">';
      echo '<div class="users">';
      for($k = 0; $k<count($usersjson->users); $k++){
        $userobj = $usersjson->users[$k];
        echo '<div class="comment">
                <img src="'.$userobj->pic.'" alt="">
                <div class="comment-head">
                  <h4>'.$userobj->fio.'</h4></div>
                <div class="comment-text">
                  <p>Рейтинг: '.$userobj->rating.'</p>
                </div>
              </div>';
      }
      echo '</div>';
      echo '</div>';
      echo '</div>';
    }
	include 'modules/footer.php';
?>
</body>