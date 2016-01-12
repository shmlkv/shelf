<?php
	if($_COOKIE['uid']){
		$booksFile = file_get_contents("../database/books.json");
		$booksArray = json_decode($booksFile);
		$userbookexist = false;
		for($a = 0; $a<count($booksArray->books[$_POST['bookid']]->readers); $a++){
			if($booksArray->books[$_POST['bookid']]->readers[$a]->uid == $_COOKIE['uid']){
				$userbookexist = true;
			}
		}
		if($_POST['bookid']){
			if(!$userbookexist){
				if($_POST['comment']){
					array_push($booksArray->books[$_POST['bookid']]->readers,  array('uid' => $_COOKIE['uid'], 'rating' => $_POST['rating'], 'comment' => $_POST['comment'], 'commentrating' => 0));
				}else{
					array_push($booksArray->books[$_POST['bookid']]->readers,  array('uid' => $_COOKIE['uid'], 'rating' => $_POST['rating']));
				}
				$added = true;
				if(in_array($_COOKIE['uid'], $booksArray->books[$_POST['bookid']]->toread)){
					for($i = 0; $i<count($booksArray->books[$_POST['bookid']]->toread); $i++){
						if($booksArray->books[$_POST['bookid']]->toread[$i] == $_COOKIE['uid']){
							unset($booksArray->books[$_POST['bookid']]->toread[$i]);
						}
					}
				}
			}
		}else{
			if($_POST['title'] && $_POST['author'] && $_POST['rating']){
				(!$_POST['cover']) ? $cover = 'covers/no-book.jpg' : $cover = $_POST['cover'];
				if($_POST['comment']){
					$bookobj = array('id' => count($booksArray->books), 'title' => $_POST['title'],'author' => $_POST['author'],'cover' => $cover,'readers' => array(array('uid' => $_COOKIE['uid'], 'rating' => $_POST['rating'], 'comment' => $_POST['comment'],'commentrating' => 0)),'toread' => array(), 'averagerating' => $_POST['rating']);
				}else{
					$bookobj = array('id' => count($booksArray->books), 'title' => $_POST['title'],'author' => $_POST['author'],'cover' => $cover,'readers' => array(array('uid' => $_COOKIE['uid'], 'rating' => $_POST['rating'])),'toread' => array(), 'averagerating' => $_POST['rating']);
				}
				array_push($booksArray->books, $bookobj);
				$added = true;
			}
			
		}
		if($added){
			fwrite(fopen('../database/books.json', 'w'), json_encode($booksArray, JSON_PRETTY_PRINT, JSON_UNESCAPED_UNICODE));
	
			$statsFile = file_get_contents("../database/stats.json");
			$stastArray = json_decode($statsFile);
			$stastArray->books = count($booksArray->books);
			fwrite(fopen('../database/stats.json', 'w'), json_encode($stastArray, JSON_PRETTY_PRINT));

		}
		
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
?>
