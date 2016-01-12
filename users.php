<!DOCTYPE html>
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
  <title>Пользователи</title>
  <link rel="stylesheet" href="css/main.css">
  <script type="text/javascript" src="http://userapi.com/js/api/openapi.js?34"></script>
</head>
<body>
<?php
  include 'modules/header.php';

  $usersfile = file_get_contents("database/users.json");
  $usersjson = json_decode($usersfile);

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
        $booksread = 0;
        $bookstoread = 0;
        for($i = 0; $i<count($booksjson->books); $i++){
          for($j = 0; $j<count($booksjson->books[$i]->readers); $j++){
            if($_GET['user'] == $booksjson->books[$i]->readers[$j]->uid){
              $booksread = $booksread + 1;
            }
          }
          for($j = 0; $j<count($booksjson->books[$i]->toread); $j++){
            if($_GET['user'] == $booksjson->books[$i]->toread[$j]){
              $bookstoread = $bookstoread + 1;
            }
          }
        }
        echo '<div class="comment">
                <img src="'.$userobj->pic.'" alt="">
                <div class="comment-head">
                  <h4>'.$userobj->fio.'</h4></div>
                <div class="comment-text">
                  <p>Рейтинг: '.$userobj->rating.'</p>
                  <p>Книг прочитал: '.$booksread.'</p>
                  <p>Книг хочет прочитать: '.$bookstoread.'</p>
                </div>
              </div>';
        for($i = 0; $i <count($booksjson->books); $i++){
          for($j = 0; $j<count($booksjson->books[$i]->readers); $j++){
            if ($_GET['user']  == $booksjson->books[$i]->readers[$j]->uid){
              echo '<div class="book-block">';
                  echo '<a href="book.php?book=',$booksjson->books[$i]->id,'">';
                  echo '<img src="', $booksjson->books[$i]->cover,'" alt="">';
                  echo '<span class="title">',$booksjson->books[$i]->title,'</span>';
                  echo '<span class="author">',$booksjson->books[$i]->author,  '</span>';
                echo'</a>';
              echo '</div>';
            }
          }
        }
      }else{
      echo '<div class="users">';
      for($i = 0; $i<count($usersjson->users); $i++){
        $userobj = $usersjson->users[$i];
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