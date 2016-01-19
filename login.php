<?php
// информация второго приложения
if ($_REQUEST['hash']==md5('5204968'.$_REQUEST['uid'].'QjdRt1xAokptMQ0xBPqi')) {
	session_start();
	setcookie('uid',$_REQUEST['uid']);
	setcookie('first_name',$_REQUEST['first_name']);
	setcookie('last_name',$_REQUEST['last_name']);
	setcookie('photo',$_REQUEST['photo']);
	setcookie('photo_rec',$_REQUEST['photo_rec']);
	setcookie('log',true);
}
header("Location: index.php");
?>