<?php
	if($_COOKIE['uid']){
		$booksFile = file_get_contents("../database/books.json");
		$booksArray = json_decode($booksFile);

		if($_POST['bookid']){
			array_push($booksArray->books[$_GET['book']]->readers,  array('uid' => $_COOKIE['uid'], 'rating' => $_POST['rating']));
			($_POST['comment']) ? array_push($booksArray->books[$_GET['book']]->comments, array('uid' => $_COOKIE['uid'], 'comment' => $_POST['comment'], 'rating' => 0));
		}else{
			(!$_POST['cover']) ? $cover = 'covers/no-book.jpg' : $cover = $_POST['cover'];
			($_POST['comment']) ? $comments[0] = array('uid' => $_COOKIE['uid'], 'comment' => $_POST['comment'], 'rating' => 0) : $comments;
			
			$bookobj = array('id' => count($booksArray->books), 'title' => $_POST['title'],'author' => $_POST['author'],'cover' => $cover,'readers' => array('uid' => $_COOKIE['uid'], 'rating' => $_POST['rating']), 'averagerating' => $_POST['rating'], 'comments' => $comments);
			array_push($booksArray->books, $bookobj);
		}
		fwrite(fopen('../database/books.json', 'w'), json_encode($booksArray, JSON_PRETTY_PRINT, JSON_UNESCAPED_UNICODE));

		$statsFile = file_get_contents("../database/stats.json");
		$stastArray = json_decode($statsFile);
		$stastArray->books = count($booksArray->books);
		fwrite(fopen('../database/stats.json', 'w'), json_encode($stastArray, JSON_PRETTY_PRINT));
	}
	header('Location: ' . $_SERVER['HTTP_REFERER']);

	//if($_POST['comment']){
	//	$comments[0] = array('uid' => $_POST['uid'], 'comment' => $_POST['comment'], 'rating' => 0);
	//}else{
	//	$comments;
	//}

	//if(!$_POST['cover']){
	//	$cover = 'covers/no-book.jpg';
	//}else{
	//	$cover = $_POST['cover'];
	//}
?>
