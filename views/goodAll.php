<?php
/** @var \app\models\Good[] $goods */
?>
<h1>Товары</h1>
<br>
<?php foreach ($goods as $good) :?>
    <h2><?= $good->name ?></h2>
    <a href="?c=good&a=one&id=<?= $good->id ?>">подробнее</a>
    <hr>
<?php endforeach; ?>

<br>
<a href="?c=good&a=edit">добавить товар</a>