<?php
	if (isset($_COOKIE['log'])) {
		
		$booksFile = file_get_contents("../database/books.json");
		$booksArray = json_decode($booksFile);
		$booksArray->books[$_GET['book']]->toread[count($booksArray->books[$_GET['book']]->toread)] = $_COOKIE['uid'];
		echo $booksArray->books[$_GET['book']]->toread[count($booksArray->books[$_GET['book']]->toread)];
		array_push($booksArray->books[$_GET['book']]->toread, $_COOKIE['uid']);
		fwrite(fopen('../database/stats.json', 'w'), json_encode($booksArray, JSON_PRETTY_PRINT));
	}
?>