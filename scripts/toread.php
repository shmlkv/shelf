<?php
	if (isset($_COOKIE['log'])) {
		
		$booksFile = file_get_contents("../database/books.json");
		$booksArray = json_decode($booksFile);
		
		array_push($booksArray->books[$_GET['book']]->toread, array($_COOKIE['uid']));
		fwrite(fopen('../database/books.json', 'w'), json_encode($booksArray, JSON_PRETTY_PRINT));
	}
?>