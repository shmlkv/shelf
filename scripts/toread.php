<?php
	if (isset($_COOKIE['log']) && $_GET['book']) {
		$booksFile = file_get_contents("../database/books.json");
		$booksArray = json_decode($booksFile);
		$exist = false;
		
		if (!in_array($_COOKIE['uid'], $booksArray->books[$_GET['book']]->toread)) {
			array_push($booksArray->books[$_GET['book']]->toread, $_COOKIE['uid']);
		}else{
			$booksArray->books[$_GET['book']]->toread = array_diff($booksArray->books[$_GET['book']]->toread, array($_COOKIE['uid']));
		}
		
		fwrite(fopen('../database/books.json', 'w'), json_encode($booksArray, JSON_PRETTY_PRINT));
	}
	header('Location: ' . $_SERVER['HTTP_REFERER']);
?>