<?php
	//if(isset($_COOKIE['log'])){
echo '<div class="popup" data-popup="popup-addbook">
    	<div class="popup-inner">
    	    <h2 class="center">Добавление книги</h2>
			<a class="close" data-popup-close="popup-addbook" href="#">&times;</a>
			<div id="content">
				<form action="scripts/addbook.php" method="post">
					<input type="text" name="title" placeholder="Название" autofocus required>
					<input type="text" name="author" placeholder="Автор" autofocus required>
					<input type="text" name="comment" placeholder="Ваш комментарий о книге" class="popup-comment">
					<input type="text" name="cover" placeholder="url картинки (прости, брат, но пока только так)">
					<span class="text-center">Оценка</span>
					<input type="range" name="rating" min="0" max="10" step="1" value="5"> 
					<input type="hidden" name="uid" value="'.$_COOKIE['uid'].'">
					<input type="submit">
				</form>
			</div>
    	</div>
	</div>';
	if(isset($_GET['book'])){
		$booksfile = file_get_contents("database/books.json");
		$booksjson = json_decode($booksfile);
		$bookobj = $booksjson->books[$_GET['book']];
		echo '<div class="popup" data-popup="popup-addthisbook">
    			<div class="popup-inner">
					<h2 class="center">Добавление книги</h2>
					<a class="close" href="#">&times;</a>
					<div id="content">
						<form action="scripts/addbook.php" method="post">
							<input type="text" name="title" placeholder="'.$bookobj->title.'" disabled="disabled">
							<input type="text" name="author" placeholder="'.$bookobj->author.'" disabled="disabled">
							<input type="text" name="comment" placeholder="Ваш комментарий о книге" class="popup-comment">
							<span class="text-center">Оценка</span>
							<input type="range" name="rating" min="0" max="10" step="1" value="5"> 
							<input type="hidden" name="bookid" value="'.$bookobj->id.'">
							<input type="submit">
						</form>
					</div>
				</div>
			</div>';
	}
 ?>

<!--  	 -->