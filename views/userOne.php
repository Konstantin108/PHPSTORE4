<?php
/** @var \app\models\User $user */
?>

<h2>Логин: <?= $user->login ?></h2>
<h2>Имя: <?= $user->name ?></h2>
<h2>Должность: <?= $user->position ?></h2>

<?php if ($user->is_admin == 1) : ?>
    <br>
    <h3 style="color: red">данный пользователь является администратором</h3>
    <br>
<?php elseif ($user->is_admin == 2) : ?>
    <br>
    <h3 style="color: red">данный пользователь имеет расширенные права</h3>
    <br>
    <a href="?c=user&a=edit&id=<?= $user->id ?>">редактировать</a>
    <a href="?c=user&a=del&id=<?= $user->id ?>">удалить</a>
<?php else : ?>
    <br>
    <a href="?c=user&a=edit&id=<?= $user->id ?>">редактировать</a>
    <a href="?c=user&a=del&id=<?= $user->id ?>">удалить</a>
<?php endif; ?>

<a href="?c=user&a=all">назад</a>
<hr>
