<?php
/** @var \app\models\User[] $users */
?>

<?php foreach ($users as $user) :?>
    <h2><?= $user->login ?></h2>
    <a href="?c=user&a=one&id=<?= $user->id ?>">подробнее</a>
    <hr>
<?php endforeach; ?>
