<!DOCTYPE html>
<?php
  $usersfile = file_get_contents("database/users.json");
  $usersjson = json_decode($usersfile);
  if (isset($_GET['user'])){
    for($k = 0; $k<count($usersjson->users); $k++){
          if($_GET['user'] == $usersjson->users[$k]->uid){
             $title = $usersjson->users[$k]->fio;
          }
        }
   
  }else{
    $title = 'Все пользователи';
  }
  
?>
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
  <title><?=$title?></title>
  <link rel="stylesheet" href="css/main.css">
  <script type="text/javascript" src="http://userapi.com/js/api/openapi.js?34"></script>
</head>
<body>
<?php
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
        echo '<div class="comment" style="margin-bottom: 20px">
                <img src="'.$userobj->pic.'" alt="">
                <div class="comment-head">
                  <a class="comment-head-name">'.$userobj->fio.'</a></div>
                <div class="comment-text">
                  <info>Рейтинг: '.$userobj->rating.'</info>
                  <info>Книг хочет прочитать: '.$bookstoread.'</info>
                  <info>Книг прочитал: '.$booksread.'</info>
                </div>
              </div>';
               echo '<div class="wantto">
            <info style="margin-bottom: 20px">Хочет прочитать</info>';
            $userbooksarray = array();
         for($i = 0; $i <count($booksjson->books); $i++){
          for($k = 0; $k<count($booksjson->books[$i]->readers); $k++){
              if ($_GET['user'] == $booksjson->books[$i]->readers[$k]->uid){
                array_push($userbooksarray, array('id' => $booksjson->books[$i]->id, 'title' =>$booksjson->books[$i]->title, 'author' => $booksjson->books[$i]->author, 'cover' => $booksjson->books[$i]->cover, 'date' =>  $booksjson->books[$i]->readers[$k]->date));
              }
            }
          }
        usort($userbooksarray, function($a, $b){
          $date1 = strtotime($b['date']);
          $date2 = strtotime($a['date']);
          return ($date1-$date2);
        }); 
        for($i = 0; $i <count($userbooksarray); $i++){
              echo '<div class="book-block">';
                  echo '<a href="book.php?book=',$userbooksarray[$i]['id'],'">';
                    echo '<img src="',$userbooksarray[$i]['cover'],'" alt="">';
                    echo '<span class="title">',$userbooksarray[$i]['title'],'</span>';
                    echo '<span class="author">',$userbooksarray[$i]['author'],  '</span>';
                  echo'</a>';
              echo '</div>';
        }
        echo '</div>';
        echo '<info style="margin-bottom: 20px">Прочитал</info>';
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
      usort($usersjson->users, function($a, $b){
        return ($b->rating - $a->rating);
      });
      for($i = 0; $i<count($usersjson->users); $i++){
        $userobj = $usersjson->users[$i];
        echo '<div class="comment">
                <a  href="users.php?user='.$userobj->uid.'">
                <img src="'.$userobj->pic.'" alt="">
                <div class="comment-head">
                  <a class="comment-head-name" href="users.php?user='.$userobj->uid.'">'.$userobj->fio.'</a>
                </div>
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
  include 'modules/popup.php';
	include 'modules/footer.php';
?>
<script src="scripts/main.js"></script>
</body>