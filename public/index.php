<?php
use app\services\Autoload;
use app\models\Good;
use app\models\User;

include dirname(__DIR__) . "/services/Autoload.php";
spl_autoload_register([(new Autoload()), 'load']);

$controllerName = 'user';     //<-- получение контроллера
if(!empty(trim($_GET['c'])))
{
    $controllerName = trim($_GET['c']);
}

$actionName = '';     //<-- получение экшена
if(!empty(trim($_GET['a'])))
{
    $actionName = trim($_GET['a']);
}

$controllerClass = 'app\\controllers\\' . ucfirst($controllerName) . 'Controller';     //<-- создаём название класса контроллера
if(class_exists($controllerClass))
{
    $controller = new $controllerClass();
    echo $controller->run($actionName);
}else{
    echo '404';
}

//_________________________________________________________________________________________________________

$userModel = User::getOne(360);     //<-- получение одной записи (без создания экземпляра класса)
$userModels = User::getAll();     //<-- получение всех записей (без создания экземпляра класса)

//$good = new Good();     //<-- создание экземпляра класса Good
//$goodModel = $good->getOne(97);     <-- получение одной записи
$goodModels = Good::getAll();     //<-- получение всех записей

//$user = new User();     <-- создание экземпляра класса User
//$user->login = 'user9';    <-- Добавление строки в таблицу users
//$user->password = '1238';
//$user->name = 'Michael';
//$user->is_admin = 2;
//$user->position = 'driver';
//$user->save();

//$user->login = 'user7';      <-- Редактирование строки из таблицы users
//$user->password = '1237';
//$user->name = 'Jack';
//$user->is_admin = 0;
//$user->position = 'doctor';
//$user->id = 378;
//$user->save();

//$user->id = '399';      <-- Удаление строки из таблицы users
//$user->delete();

//$good->name = 'Nokia A40';      <-- Добавление строки в таблицу goods
//$good->price = '5990';
//$good->info = 'very good phone';
//$good->counter = '1';
//$good->save();

//$good = new Good();      <-- Редактирование строки из таблицы goods
//$good->name = 'Nokia A40';
//$good->price = '4990';
//$good->info = 'old model';
//$good->counter = '1';
//$good->id = 119;
//$good->save();

//$good->id = '119';      <-- Удаление строки из таблицы goods
//$good->delete();

echo '<pre>';
//var_dump($userModel);
//echo  "<hr>";
var_dump($userModels);
echo  "<hr>";
//var_dump($goodModel);
//echo  "<hr>";
var_dump($goodModels);
echo  "<hr>";



