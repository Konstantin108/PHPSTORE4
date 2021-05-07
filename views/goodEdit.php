<?php
/** @var \app\models\Good $good */
?>

<?php if($good->id) : ?>
    <h2>редактирование товара <?= $good->name ?></h2>
<?php else : ?>
    <h2>добавление товара</h2>
<?php endif; ?>

<br>
<form method="post" action="?c=good&a=update">
    <input type="hidden" id="id" name="id" value="<?= $good->id ?>">
    <input type="text" id="name" name="name" value="<?= $good->name ?>">
    <input type="text" id="price" name="price" value="<?= $good->price ?>">
    <input type="text" id="info" name="info" value="<?= $good->info ?>">
    <input type="hidden" id="counter" name="counter" value="<?= $good->counter ?>">
    <input type="submit" value="сохранить">
</form>

<?php if($good->id) : ?>
    <a href="?c=good&a=one&id=<?= $good->id ?>">назад</a>
<?php else : ?>
    <a href="?c=good&a=all">назад</a>
<?php endif; ?>

<hr>