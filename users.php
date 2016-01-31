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
<!DOCTYPE html>
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
      echo '<div class="wrap-profile">
              <div class="wrap">
                <img src="'.$userobj->pic.'" alt="" class="profile-img">
                <div class="profile-info">
                  <h1>'.$userobj->fio.'</h1>
                  <info>Рейтинг: '.$userobj->rating.'</info>
                  <info>Книг хочет прочитать: '.$bookstoread.'</info>
                  <info>Книг прочитал: '.$booksread.'</info>
                  <info><a href="https://vk.com/id'.$userobj->uid.'" class="icon-vk"></a></info>
                </div>
              </div>
            </div>';
      echo '<div class="wrap">
                <info style="margin-bottom: 20px">Хочет прочитать</info>';
      $userreadedbooksarray = array();
      for($i = 0; $i <count($booksjson->books); $i++){
          for($k = 0; $k<count($booksjson->books[$i]->readers); $k++){
            if ($_GET['user'] == $booksjson->books[$i]->readers[$k]->uid){
             array_push($userreadedbooksarray, array('id' => $booksjson->books[$i]->id, 'title' =>$booksjson->books[$i]->title, 'author' => $booksjson->books[$i]->author, 'cover' => $booksjson->books[$i]->cover, 'date' =>  $booksjson->books[$i]->readers[$k]->date));
            }
          }
      }

      $userwantedbooksarray = array();
      for($i = 0; $i <count($booksjson->books); $i++){
          for($k = 0; $k<count($booksjson->books[$i]->toread); $k++){
            if ($_GET['user'] == $booksjson->books[$i]->toread[$k]){
              array_push($userwantedbooksarray, array('id' => $booksjson->books[$i]->id, 'title' =>$booksjson->books[$i]->title, 'author' => $booksjson->books[$i]->author, 'cover' => $booksjson->books[$i]->cover, 'date' =>  $booksjson->books[$i]->readers[$k]->date));
            }
          }
      }

      usort($userreadedbooksarray, function($a, $b){
        $date1 = strtotime($b['date']);
        $date2 = strtotime($a['date']);
        return ($date1-$date2);
      }); 
      usort($userwantedbooksarray, function($a, $b){
        $date1 = strtotime($b['date']);
        $date2 = strtotime($a['date']);
        return ($date1-$date2);
      }); 
      for($i = 0; $i <count($userwantedbooksarray); $i++){
        echo '<div class="book-block">
                <a href="book.php?book=',$userwantedbooksarray[$i]['id'],'">
                  <img src="',$userwantedbooksarray[$i]['cover'],'" alt="">
                  <span class="title">',$userwantedbooksarray[$i]['title'],'</span>
                  <span class="author">',$userwantedbooksarray[$i]['author'],  '</span>
                </a>
              </div>';
      }

      echo '<info style="margin-bottom: 20px">Прочитал</info>';
      for($i = 0; $i <count($userreadedbooksarray); $i++){
            echo '<div class="book-block">
                    <a href="book.php?book=',$userreadedbooksarray[$i]['id'],'">
                      <img src="', $userreadedbooksarray[$i]['cover'],'" alt="">
                      <span class="title">',$userreadedbooksarray[$i]['title'],'</span>
                      <span class="author">',$userreadedbooksarray[$i]['author'],  '</span>
                    </a>
                  </div>';
      }
    }else{
      echo '<div class="wrap">';//
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
  include 'modules/popup.php';
	include 'modules/footer.php';
?>
<script src="scripts/main.js"></script>
</body>