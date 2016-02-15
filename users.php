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
  <meta name="viewport" content="width=device-width, initial-scale=1">
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
      $readedbooks = array();
      $wantedbooks = array();
      for($i = 0; $i <count($booksjson->books); $i++){
          for($k = 0; $k<count($booksjson->books[$i]->readers); $k++){
            if ($_GET['user'] == $booksjson->books[$i]->readers[$k]->uid){
             array_push($readedbooks, array(
                'id' => $booksjson->books[$i]->id,
                'title' =>$booksjson->books[$i]->title,
                'author' => $booksjson->books[$i]->author,
                'cover' => $booksjson->books[$i]->cover,
                'date' =>  $booksjson->books[$i]->readers[$k]->date,
                'desc' =>  $booksjson->books[$i]->desc,
                'readers' => count($booksjson->books[$i]->readers),
                'toread' => count($booksjson->books[$i]->toread),
                'rating' => $booksjson->books[$i]->averagerating
              ));
            }
          }
          for($j = 0; $j<count($booksjson->books[$i]->toread); $j++){
            if ($_GET['user'] == $booksjson->books[$i]->toread[$j]){
              array_push($wantedbooks, array('id' => $booksjson->books[$i]->id, 'title' =>$booksjson->books[$i]->title, 'author' => $booksjson->books[$i]->author, 'cover' => $booksjson->books[$i]->cover, 'date' =>  $booksjson->books[$i]->readers[$j]->date, 'desc' =>  $booksjson->books[$i]->desc));
            }
          }
      }

      usort($readedbooks, function($a, $b){
        $date1 = strtotime($b['date']);
        $date2 = strtotime($a['date']);
        return ($date1-$date2);
      });
      usort($wantedbooks, function($a, $b){
        $date1 = strtotime($b['date']);
        $date2 = strtotime($a['date']);
        return ($date1-$date2);
      });

      echo '<div class="wrap" style="margin-top:0px;">
              <div class="notebook">
                <input type="radio" name="notebook1" id="notebook1_1" checked>
                <label for="notebook1_1"><span class="icon-book"></span>Прочитанные ('.count($readedbooks).')</label>
                <input type="radio" name="notebook1" id="notebook1_2">
                <label for="notebook1_2"><span class="icon-bookmarks"></span>Желаемые ('.count($wantedbooks).')</label>
              <div>';
        echo '<div id="preview">
                    <img src="" class="book-img">
                  
                  <div class="book-info">
                    <span class="title"></span>
                    <span class="author"></span>
                    <span class="desc"></span>
                    <div class="links">
                        <a title="Прочитавшие книгу" href="" class="btn inline addbook" id="1"><span class="icon-people"></span></a>
                        <a title="Желающие прочитать" href="" class="btn inline addbook" id="2"><span class="icon-bookmarks"></span></a>
                        <a title="Рейтинг" href="" class="btn inline addbook" id="3"><span class="icon-stats-bars"></span></a>
                    </div>
                    </div>
              </div>';
        echo '<ul id="gird">';
        for($i = 0; $i <count($readedbooks); $i++){
          echo '<li class="book-block"
                   data-src="', $readedbooks[$i]['cover'],'" 
                   data-title="',$readedbooks[$i]['title'],'" 
                   data-author="',$readedbooks[$i]['author'],'" 
                   data-desc="',$readedbooks[$i]['desc'],'" 
                   data-readers="',$readedbooks[$i]['readers'],'" 
                   data-toread="',$readedbooks[$i]['toread'],'" 
                   data-rating="',$readedbooks[$i]['rating'],'" 
                   href="book.php?book=',$readedbooks[$i]['id'],'"
                >
                    <img src="', $readedbooks[$i]['cover'],'" alt="">
                    <span class="title">',$readedbooks[$i]['title'],'</span>
                    <span class="author">',$readedbooks[$i]['author'],'</span>
                </li>';
        }
        echo '</ul>
            </div>
            <div>
            <ul id="gird">';
        for($i = 0; $i <count($wantedbooks); $i++){
          echo '<li class="book-block" data-src="', $wantedbooks[$i]['cover'],'" data-title="',$wantedbooks[$i]['title'],'" data-author="',$wantedbooks[$i]['author'],'" data-desc="',$wantedbooks[$i]['desc'],'" href="book.php?book=',$wantedbooks[$i]['id'],'">
                    <img src="', $wantedbooks[$i]['cover'],'" alt="">
                    <span class="title">',$wantedbooks[$i]['title'],'</span>
                    <span class="author">',$wantedbooks[$i]['author'],'</span>
                </li>';
        }
      echo '</div>
      </ul>
            </div>';
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
