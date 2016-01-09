<?php
	
	$booksFile = file_get_contents("../database/books.json");
	$booksArray = json_decode($booksFile);

	if(!$_POST['cover']){
		$cover = 'covers/no-book.jpg';
	}else{
		$cover = $_POST['cover'];
	}
	if($_POST['comment']){
		$comments = array('uid' => $_POST['uid'], 'comment' => $_POST['comment']);
	}else{
		$comments;
	}
	$obj = array('id' => count($booksArray->books), 'title' => $_POST['title'],'author' => $_POST['author'],'cover' => $cover,'readed' => array($_POST['uid']),'comments' => );
	array_push($booksArray->books, $obj);
	fwrite(fopen('../database/books.json', 'w'), json_encode($booksArray, JSON_PRETTY_PRINT, JSON_UNESCAPED_UNICODE));

	$statsFile = file_get_contents("../database/stats.json");
	$stastArray = json_decode($statsFile);
	$stastArray->books = count($booksArray->books);
	fwrite(fopen('../database/stats.json', 'w'), json_encode($stastArray, JSON_PRETTY_PRINT));

	header("Location: ../index.php");
?>