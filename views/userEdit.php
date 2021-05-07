<?php
/** @var \app\models\User $user */
?>

<?php if($user->id) : ?>
    <h2>редактирование пользователя <?= $user->login ?></h2>
<?php else : ?>
    <h2>добавление пользователя</h2>
<?php endif; ?>

<br>
<form method="post" action="?c=user&a=update">
    <input type="hidden" id="id" name="id" value="<?= $user->id ?>">
    <input type="text" id="login" name="login" value="<?= $user->login ?>">
    <input type="text" id="password" name="password" value="<?= $user->password ?>">
    <input type="text" id="name" name="name" value="<?= $user->name ?>">
    <input type="text" id="position" name="position" value="<?= $user->position ?>">
    <select name="is_admin" id="is_admin">
        <option value="nothing">Значение не выбрано</option>
        <option value="yes">Да</option>
        <option value="no">Нет</option>
    </select>
    <input type="submit" value="сохранить">
</form>

<?php if($user->id) : ?>
    <a href="?c=user&a=one&id=<?= $user->id ?>">назад</a>
<?php else : ?>
    <a href="/">назад</a>
<?php endif; ?>

<hr>