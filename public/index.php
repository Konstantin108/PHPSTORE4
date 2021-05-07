<?php

use app\models\Good;
use app\models\User;
use app\services\Autoload;

include dirname(__DIR__) . "/services/Autoload.php";
spl_autoload_register([(new Autoload()), 'load']);

$controllerName = 'user';     //<-- получение контроллера
if (!empty(trim($_GET['c']))) {
    $controllerName = trim($_GET['c']);
}

$actionName = '';     //<-- получение экшена
if (!empty(trim($_GET['a']))) {
    $actionName = trim($_GET['a']);
}

$controllerClass = 'app\\controllers\\' . ucfirst($controllerName) . 'Controller';     //<-- создаём название класса контроллера
if (class_exists($controllerClass)) {
    $controller = new $controllerClass();
    echo $controller->run($actionName);
} else {
    echo '404';
}

//_________________________________________________________________________________________________________

$userModel = User::getOne(378);     //<-- получение одной записи (без создания экземпляра класса)
$userModels = User::getAll();     //<-- получение всех записей (без создания экземпляра класса)

//$good = new Good();     //<-- создание экземпляра класса Good
//$goodModel = $good->getOne(97);     <-- получение одной записи
$goodModels = Good::getAll();     //<-- получение всех записей

//$user = new User();     //<-- создание экземпляра класса User
//$user->login = 'user8';    //<-- Добавление строки в таблицу users
//$user->password = '1238';
//$user->name = 'Michael';
//$user->is_admin = 2;
//$user->position = 'driver';
//$user->save();

//$user->login = 'user7';      //<-- Редактирование строки из таблицы users(надо создавать экземпляр класса)
//$user->password = '1237';
//$user->name = 'Jack';
//$user->is_admin = 0;
//$user->position = 'doctor';
//$user->id = 378;
//$user->save();

//$user = User::getOne(359);
//$user->login = 'user2';      //<-- Редактирование строки из таблицы users
//$user->password = '1232';        //(если не был создан экземпляр класса)
//$user->name = 'Andrey';
//$user->is_admin = 0;
//$user->position = 'doctor';
//$user->save();

//$user->id = '399';      <-- Удаление строки из таблицы users(надо создавать экземпляр класса)
//$user->delete();

//$user = USer::getOne(380)->delete();      //<-- Удаление строки из таблицы users
//(если не был создан экземпляр класса)

//$good = new Good;
//$good->name = 'Samsung Galaxy Note 10';      //<-- Добавление строки в таблицу goods
//$good->price = '88000';
//$good->info = 'very good phone';
//$good->counter = '1';
//$good->save();

//$good = new Good();      <-- Редактирование строки из таблицы goods(надо создавать экземпляр класса)
//$good->name = 'Nokia A40';
//$good->price = '4990';
//$good->info = 'old model';
//$good->counter = '1';
//$good->id = 119;
//$good->save();

//$good = Good::getOne(120);      //<-- Редактирование строки из таблицы goods
//$good->name = 'Xiaomi Mi9t Pro';              //(если не был создан экземпляр класса)
//$good->price = '55000';
//$good->info = 'old model';
//$good->counter = '1';
//$good->save();

//$good->id = '117';      //<-- Удаление строки из таблицы goods(надо создавать экземпляр класса)
//$good->delete();

//$good = Good::getOne(115)->delete();      //<-- Удаление строки из таблицы goods
//(если не был создан экземпляр класса)

//echo '<pre>';
//var_dump($userModel);
//echo  "<hr>";
//var_dump($userModels);
//echo "<hr>";
//var_dump($goodModel);
//echo  "<hr>";
//var_dump($goodModels);
//echo "<hr>";



