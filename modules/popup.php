<?php
	echo '<div id="addbook" class="overlay">
			<div class="popup">
				<h2 class="center">Добавление книги</h2>
				<a class="close" href="#">&times;</a>
				<div id="content">
					<form action="scripts/addbook.php" method="post">
						<input type="text" name="title" placeholder="Название" autofocus required>
						<input type="text" name="author" placeholder="Автор" autofocus required>
						<input type="text" name="comment" placeholder="Ваш комментарий о книге" class="popup-comment">
						<input type="text" name="cover" placeholder="url картинки">
						<input type="hidden" name="uid" value="'.$_COOKIE['uid'].'">
						<input type="submit">
					</form>
				</div>
			</div>
		</div>'
 ?>
<!--  <input type="file" name="file"> -->