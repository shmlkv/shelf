<!DOCTYPE html>
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
  <title>Селебретис</title>
  <link rel="stylesheet" href="css/main.css">
  <script type="text/javascript" src="http://userapi.com/js/api/openapi.js?34"></script>
</head>
<body>
<?php
	include 'modules/header.php';
      $file = file_get_contents("database/books.json");
      $json = json_decode($file);
      echo '<div id="content">
              <div class="wrap">';
          echo '<info style="margin-bottom: 20px">Books of celebrities</info>';
          for($i = 1; $i <count($json->books); $i++){
                echo '<div class="book-block">';
                    echo '<a href="book.php?book=',$json->books[$i]->id,'">';
                      echo '<img src="',$json->books[$i]->cover,'" alt="">';
                      echo '<span class="title">',$json->books[$i]->title,'</span>';
                      echo '<span class="author">',$json->books[$i]->author,  '</span>';
                    echo'</a>';
                echo '</div>';
          }
        echo '</div>
          </div>';
  include 'modules/popup.php';
	include 'modules/footer.php';
?>
</body>