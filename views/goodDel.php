<?php
/** @var \app\models\Good $good */
?>

<h2>удалить товар <?= $good->login ?>?</h2>
<br>
<a href="?c=good&a=getDel&id=<?= $good->id ?>">да</a>
<a href="?c=good&a=one&id=<?= $good->id ?>">назад</a>