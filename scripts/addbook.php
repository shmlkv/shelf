<?php

	$booksFile = file_get_contents("../database/books.json");
	$booksArray = json_decode($booksFile);
	//echo $booksArray->books[0]->id;
	//$bookObject = new Book;
	//$bookObject->setParams(count($booksArray->books), $_POST['title'], $_POST['author'], $_POST['comment'], $_POST['cover'], $_POST['uid']);
	$c =  array('uid' => $_POST['uid'], 'comment' => $_POST['comment']);
	$obj = array('id' => count($booksArray->books), 'title' => $_POST['title'],'author' => $_POST['author'],'cover' => $_POST['cover'],'readed' => array($_POST['uid']),'comments' => $c);
	array_push($booksArray->books, $obj);
	echo $booksArray->books[3]->id;
	fwrite(fopen('../database/books.json', 'w'), json_encode($booksArray));
	echo json_encode($bookObject);
	//echo $_POST['title'].'<br>';
	//echo $_POST['author'].'<br>';
	//echo $_POST['comment'].'<br>';
	//echo $_POST['file'].'<br>';
	//echo $_POST['uid'].'<br>';
	
	//echo count($booksjson->books);

	//for($i = 0; $i <count($books->users); $i++){
	//  if ($_COOKIE['uid'] === $usersjson->users[$i]->uid){
	//    $userexist=true;
	//  }
	//}
?>