<?php

namespace app\controllers;

use app\repositories\GoodRepository;
use app\services\BasketServices;

class BasketController extends Controller
{
    protected $actionDefault = 'index';

    public function indexAction()
    {
        $userId = $_SESSION['user_true']['id'];
        echo '<pre>';
        var_dump($_SESSION['goods'][$userId]);
    }

    public function addAction()
    {
        $userId = $_SESSION['user_true']['id'];
        $id = $this->getId();
        $goodRepository = new GoodRepository();
        $msg = (new BasketServices())->add($userId, $id, $goodRepository);
        return $this->redirect('', $msg);
    }
}