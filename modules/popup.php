<?php
	echo '

<div id="addbook" class="overlay">
    <div class="popup">
        <h2 class="center">Добавление книги</h2>
        <a class="close" href="#">&times;</a>
        <div id="content">
            <form action="scripts/addbook.php">
        <input type="text" placeholder="Название">
        <input type="text" placeholder="Автор">
        <input type="text" placeholder="Ваш комментарий о книге" class="popup-comment">
        <input type="file">
        <input type="submit">
    </form>
        </div>
    </div>
</div>
<script src="scripts/main.js"></script>'
 ?>