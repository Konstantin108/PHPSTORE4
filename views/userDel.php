<?php
/** @var \app\models\User $user */
?>

<h2>удалить пользователя <?= $user->login ?>?</h2>
<br>
<a href="?c=user&a=getDel&id=<?= $user->id ?>">да</a>
<a href="?c=user&a=one&id=<?= $user->id ?>">назад</a>