<?php
/** @var \app\models\Good $good */
?>

<h2>Наименование товара: <?= $good->name ?></h2>
<h2>Цена товара: <?= $good->price ?>р.</h2>
<h2>Описание: <?= $good->info ?></h2>
<br>
<a href="?c=good&a=edit&id=<?= $good->id ?>">редактировать</a>
<a href="?c=good&a=del&id=<?= $good->id ?>">удалить</a>
<a href="?c=good&a=all">назад</a>
<hr>
