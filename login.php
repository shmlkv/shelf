<?php
// информация второго приложения
if ($_REQUEST['hash']==md5('5197194'.$_REQUEST['uid'].'F6vfnzsniu4XbYMg1LS9')) { 
	setcookie('uid',$_REQUEST['uid']);
	setcookie('first_name',$_REQUEST['first_name']);
	setcookie('last_name',$_REQUEST['last_name']);
	setcookie('photo',$_REQUEST['photo']);
	setcookie('photo_rec',$_REQUEST['photo_rec']);
	setcookie('log',true);
}
header("Location: /index.php");
?>