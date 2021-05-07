<?php
/** @var \app\models\User $user
 *  @var \app\models\User[] $users
 *  @var \app\models\Good $good
 *  @var \app\models\Goods $goods
 */
?>

<?php
$previous = $_SERVER['HTTP_REFERER'];
?>

<h3 style="color: red">Необходимо заполнить все поля</h3>

<?php if ($user->id) : ?>
    <a href="?c=user&a=edit&id=<?= $user->id ?>">назад</a>
<?php elseif ($good->id) : ?>
    <a href="?c=good&a=edit&id=<?= $good->id ?>">назад</a>
<?php else : ?>
    <a href="<?= $previous ?>">назад</a>
<?php endif; ?>
