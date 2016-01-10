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
  
	echo '<div id="content">';
      echo '<div class="wrap">';
      if($_GET['user']){
        $booksfile = file_get_contents("database/books.json");
        $booksjson = json_decode($booksfile);
        for($k = 0; $k<count($usersjson->users); $k++){
          if($_GET['user'] == $usersjson->users[$k]->uid){
            $userobj = $usersjson->users[$k];
          }
        }

        echo '<div class="comment">
                <img src="'.$userobj->pic.'" alt="">
                <div class="comment-head">
                  <h4>'.$userobj->fio.'</h4></div>
                <div class="comment-text">
                  <p>Рейтинг: '.$userobj->rating.'</p>
                </div>
              </div>';
        for($i = 0; $i <count($booksjson->books); $i++){
          for($k = 0; $k<count($booksjson->books[$i]->readed); $k++){
            if ($_GET['user']  == $booksjson->books[$i]->readed[$k]){
              echo '<div class="book-block">';
                  echo '<a href="book.php?book=',$booksjson->books[$i]->id,'">';
                  echo '<span class="title">',$booksjson->books[$i]->title,'</span>';
                  echo '<span class="author">',$booksjson->books[$i]->author,  '</span>';
                  echo '<img src="',$booksjson->books[$i]->cover,'" alt="">';
                echo'</a>';
              echo '</div>';
            }
          }
        }
      }else{
      echo '<div class="users">';
      for($k = 0; $k<count($usersjson->users); $k++){
        $userobj = $usersjson->users[$k];
        echo '<div class="comment">
                <a class="dontdecorate" href="users.php?user='.$userobj->uid.'">
                <img src="'.$userobj->pic.'" alt="">
                <div class="comment-head">
                  <h4>'.$userobj->fio.'</h4></div>
                <div class="comment-text">
                  <p>Рейтинг: '.$userobj->rating.'</p>
                </div>
                </a>
              </div>';
      }
      echo '</div>';
    }
      
     
    
     echo '</div>';
      echo '</div>';
	include 'modules/footer.php';
?>

</body>