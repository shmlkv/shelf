<!DOCTYPE html>
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
  <title>Статистика</title>
  <link rel="stylesheet" href="css/main.css">
</head>
<body>
<?php 
  include 'modules/header.php';
?>
<div id="content">
  <div class="wrap">
    <h2 class="text-center">Статистика</h2>
    <?php
      $statsFile = file_get_contents("database/stats.json");
      $statsJson = json_decode($statsFile);
      echo '<p>Книг: '.$statsJson->books.'</p>';
      echo '<p>Юзеров: '.$statsJson->users.'</p>';
    ?>
  </div>
</div>
<?php
  include 'modules/popup.php';
  include 'modules/footer.php';
?>
    
</div> 
</body>
</html>