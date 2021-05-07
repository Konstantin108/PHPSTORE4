<?php
/** @var \app\models\User[] $users */
?>
<h1>Пользователи</h1>
<br>

<?php foreach ($users as $user) :?>
    <h2><?= $user->login ?></h2>
    <a href="?c=user&a=one&id=<?= $user->id ?>">подробнее</a>
    <hr>
<?php endforeach; ?>

<br>
<a href="?c=user&a=edit">добавить пользователя</a>

<!--var_dump(password_hash('123', PASSWORD_DEFAULT));-->

