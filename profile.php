<!DOCTYPE html>
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
  <title>Профиль</title>
  <link rel="stylesheet" href="css/main.css">
  <script type="text/javascript" src="http://userapi.com/js/api/openapi.js?34"></script>
</head>
<body>
<?php
  include 'modules/header.php';
  $usersfile = file_get_contents("database/users.json");
  $usersjson = json_decode($usersfile);
  for($i = 0; $i <count($usersjson->users); $i++){
    if ($_COOKIE['uid'] === $usersjson->users[$i]->uid){
      $userobj = $usersjson->users[$i];
    }
  }
	echo '<div id="content">';
      echo '<div class="wrap">';
      echo '<div class="comment">
          <img src="'.$userobj->pic.'" alt="">
          <div class="comment-head">
            <h4>'.$userobj->fio.'</h4></div>
          <div class="comment-text">
            <p>Рейтинг: '.$userobj->rating.'</p>
          </div>
        </div>';
      echo '</div>';
      echo '</div>';
	include 'modules/footer.php';
?>
<script src="scripts/main.js"></script>
</body>