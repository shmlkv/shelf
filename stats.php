<!DOCTYPE html>
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
  <title>Статистика</title>
  <link rel="stylesheet" href="css/main.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<?php 
  include 'modules/header.php';
?>
<div id="content">
  <div class="wrap">
    <h2 class="text-center">Статистика</h2>
    <?php

      $booksFile = file_get_contents("database/books.json");
      $booksJson = json_decode($booksFile);

      $usersFile = file_get_contents("database/users.json");
      $usersJson = json_decode($usersFile);
      $books = count($booksJson->books) - 1;
      echo '<p>Книг: '.$books.'</p>';
      echo '<p>Юзеров: '.count($usersJson->users).'</p>';
    ?>
  </div>
</div>  
<script src="scripts/main.js"></script>
<?php
  include 'modules/footer.php';
  include 'modules/popup.php';
?>
</div> 
</body>
</html>