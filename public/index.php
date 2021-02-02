<?php
use app\services\Autoload;
use app\services\DB;
use app\models\Good;
use app\models\USer;

include dirname(__DIR__) . "/services/Autoload.php";
spl_autoload_register([(new Autoload()), 'load']);

$user = new User($db);
$userModel = $user->getOne(356);
$userModels = $user->getAll();

$good = new Good($db);
$goodModel = $good->getOne(97);
$goodModels = $good->getAll();

echo '<pre>';
var_dump($userModel);
echo  "<hr>";
var_dump($userModels);
echo  "<hr>";
var_dump($goodModel);
echo  "<hr>";
var_dump($goodModels);



