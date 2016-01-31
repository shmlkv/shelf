<?php  session_start();
	if(isset($_COOKIE['uid'])){
		$today = date("Y-m-d\TH:i:sO");

		$booksFile = file_get_contents("../database/books.json");
		$booksArray = json_decode($booksFile);

		$usersFile = file_get_contents("../database/users.json");
		$usersArray = json_decode($usersFile);

		// Хочу прочитать \ не хочу прочитать
		if (isset($_POST['book']) && $_POST['want']) {
			if (!in_array($_COOKIE['uid'], $booksArray->books[$_POST['book']]->toread)) {
				array_push($booksArray->books[$_POST['book']]->toread, $_COOKIE['uid']);
				$_SESSION['msg'] = 'Книга была добавлена в желаемое';
			}else{
				$booksArray->books[$_POST['book']]->toread = array_diff($booksArray->books[$_POST['book']]->toread, array($_COOKIE['uid']));
				$_SESSION['msg'] = 'Книга была убрана из желаемого';
			}
			fwrite(fopen('../database/books.json', 'w'), json_encode($booksArray, JSON_PRETTY_PRINT));
			header('Location: ' . $_SERVER['HTTP_REFERER']);
		}

		//Удаление книги
		if($_GET['delete'] && isset($_GET['bookid'])){ 
			for($a = 0; $a<count($booksArray->books[$_GET['bookid']]->readers); $a++){
				if($booksArray->books[$_GET['bookid']]->readers[$a]->uid == $_COOKIE['uid']){
					array_splice($booksArray->books[$_GET['bookid']]->readers, $a, 1);

					$newrating;
					for($i = 0; $i<count($booksArray->books[$_GET['bookid']]->readers); $i++){
						$newrating  = $newrating + $booksArray->books[$_GET['bookid']]->readers[$i]->rating;
					}
					if($i){
						$booksArray->books[$_GET['bookid']]->averagerating = round($newrating / ($i+1),2);
					}else{
						$booksArray->books[$_GET['bookid']]->averagerating = 0;
					}
					
					$usersFile = file_get_contents("../database/users.json");
					$usersArray = json_decode($usersFile);
					for($i = 0; $i<count($usersArray->users); $i++){
						if($usersArray->users[$i]->uid == $_COOKIE['uid']){
							$usersArray->users[$i]->books = $usersArray->users[$i]->books - 1;
							$usersArray->users[$i]->rating = $usersArray->users[$i]->rating - 1;
						}
					}
					fwrite(fopen('../database/users.json', 'w'), json_encode($usersArray, JSON_PRETTY_PRINT, JSON_UNESCAPED_UNICODE));
					fwrite(fopen('../database/books.json', 'w'), json_encode($booksArray, JSON_PRETTY_PRINT, JSON_UNESCAPED_UNICODE));
					$_SESSION['msg'] = 'Книга удалена из вашей полки';
					header('Location: ' . $_SERVER['HTTP_REFERER']);
				}
			}
		}
		// Добавление существующей книги
		if(isset($_POST['bookid']) && isset($_POST['rating']) ){
			$userbookexist = false;
			for($a = 0; $a<count($booksArray->books[$_POST['bookid']]->readers); $a++){
				if($booksArray->books[$_POST['bookid']]->readers[$a]->uid == $_COOKIE['uid']){
					$userbookexist = true;
				}
			}
			if(!$userbookexist){
				if($_POST['comment']){
					array_push($booksArray->books[$_POST['bookid']]->readers,  array('uid' => $_COOKIE['uid'], 'date' => $today, 'rating' => $_POST['rating'], 'comment' => $_POST['comment'], 'commentrating' => 0));
				}else{
					array_push($booksArray->books[$_POST['bookid']]->readers,  array('uid' => $_COOKIE['uid'], 'date' => $today, 'rating' => $_POST['rating']));
				}
				if(in_array($_COOKIE['uid'], $booksArray->books[$_POST['bookid']]->toread)){
					for($i = 0; $i<count($booksArray->books[$_POST['bookid']]->toread); $i++){
						if($booksArray->books[$_POST['bookid']]->toread[$i] == $_COOKIE['uid']){
							unset($booksArray->books[$_POST['bookid']]->toread[$i]);
						}
					}
				}
				$added = true;
				$newrating = $_POST['rating'];
				for($i = 0; $i<count($booksArray->books[$_POST['bookid']]->readers); $i++){
					$newrating  = $newrating + $booksArray->books[$_POST['bookid']]->readers[$i]->rating;
					$items = $i;
				}
				
				$booksArray->books[$_POST['bookid']]->averagerating = round($newrating / ($items+1),2);
				$_SESSION['msg'] = 'Книга была добавлена на вашу полку';
				array_splice($booksArray->books[$_POST['bookid']]->toread, $_COOKIE['uid'], 1);
			}
		}

		//Добавление новой книги
		if($_POST['title'] && $_POST['author'] && $_POST['rating']){
			$uploaddir = '../covers/';//<----This is all I changed
			$uploadfile = $uploaddir . basename(count($booksArray->books).'.png');

			if (move_uploaded_file($_FILES['cover']['tmp_name'], $uploadfile)) {
				if($_POST['comment']){
					$bookobj = array('id' => count($booksArray->books), 'title' => $_POST['title'],'author' => $_POST['author'],'cover' => 'covers/'.count($booksArray->books).'.png','readers' => array(array('uid' => $_COOKIE['uid'], 'date' => $today, 'rating' => $_POST['rating'], 'comment' => $_POST['comment'],'commentrating' => 0)),'toread' => array(), 'averagerating' => $_POST['rating']);
				}else{
					$bookobj = array('id' => count($booksArray->books), 'title' => $_POST['title'],'author' => $_POST['author'],'cover' => 'covers/'.count($booksArray->books).'.png','readers' => array(array('uid' => $_COOKIE['uid'], 'date' => $today, 'rating' => $_POST['rating'])),'toread' => array(), 'averagerating' => $_POST['rating']);
				}
				array_push($booksArray->books, $bookobj);
				$_SESSION['msg'] = 'Книга была добавлена на вашу полку';
				$added = true;
			} else {
				echo "Possible file upload attack!\n";
			}
		}

		// Редактирование описания
		if($_POST['action'] = 'edit_desc' && isset($_POST['data']) ){
			echo 'ajax fix';
			$_SESSION['msg'] = 'Описание было отредактировано';
			$booksArray->books[$_POST['bookid']]->desc = str_replace(array("<div>", "</div>"), " ", $_POST['data']);
			fwrite(fopen('../database/books.json', 'w'), json_encode($booksArray, JSON_PRETTY_PRINT));
			
		}

		// Лайки
		if($_POST['action'] = 'like' && isset($_POST['book']) && isset($_POST['uid'])){
			for($i = 0; $i<count($booksArray->books[$_POST['book']]->readers); $i++){
				if(($booksArray->books[$_POST['book']]->readers[$i]->uid == $_POST['uid'])){
					for($j = 0; $j<count($booksArray->books[$_POST['book']]->readers[$j]->commentlikes); $j++){
						if($booksArray->books[$_POST['book']]->readers[$j]->commentlikes[$j]->uid == $_COOKIE['uid']){
							if($_POST['opinion'] == false){
								$booksArray->books[$_POST['book']]->readers[$j]->commentlikes[$j]->opinion = $_POST['opinion'];
								$booksArray->books[$_POST['book']]->readers[$i]->commentrating = $booksArray->books[$_POST['book']]->readers[$i]->commentrating - 1;
							} // WTF
							if($_POST['opinion'] == true){
								$booksArray->books[$_POST['book']]->readers[$j]->commentlikes[$j]->opinion = $_POST['opinion'];
								$booksArray->books[$_POST['book']]->readers[$i]->commentrating = $booksArray->books[$_POST['book']]->readers[$i]->commentrating + 1;
							}
							$likeexist = true;
						}
					}
					if(!$likeexist){
						array_push($booksArray->books[$_POST['book']]->readers[$i]->commentlikes, array('uid' => $_COOKIE['uid'], 'opinion' => $_POST['opinion']));
						if($_POST['opinion']){
							$booksArray->books[$_POST['book']]->readers[$i]->commentrating = $booksArray->books[$_POST['book']]->readers[$i]->commentrating + 1;
						}else{
							$booksArray->books[$_POST['book']]->readers[$i]->commentrating = $booksArray->books[$_POST['book']]->readers[$i]->commentrating - 1;
						}
					}
				}
			}
			fwrite(fopen('../database/books.json', 'w'), json_encode($booksArray, JSON_PRETTY_PRINT));
		}

		if($added){
			for($i = 0; $i<count($usersArray->users); $i++){
				if($usersArray->users[$i]->uid == $_COOKIE['uid']){
					$usersArray->users[$i]->books = $usersArray->users[$i]->books + 1;
					$usersArray->users[$i]->rating = $usersArray->users[$i]->rating + 1;
				}
				fwrite(fopen('../database/users.json', 'w'), json_encode($usersArray, JSON_PRETTY_PRINT, JSON_UNESCAPED_UNICODE));
			}
			fwrite(fopen('../database/books.json', 'w'), json_encode($booksArray, JSON_PRETTY_PRINT));
		}
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
?>
