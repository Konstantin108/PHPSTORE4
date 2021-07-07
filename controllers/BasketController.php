<?php

namespace app\controllers;

use app\repositories\GoodRepository;
use app\services\BasketServices;

class BasketController extends Controller
{
    protected $actionDefault = 'index';

    public function indexAction()
    {
        echo '<pre>';
        var_dump($_SESSION);
    }

    public function addAction()
    {
        $id = $this->getId();
        $goodRepository = new GoodRepository();
        $msg = (new BasketServices())->add($id, $goodRepository, $this->request);
        return $this->redirect('', $msg);
    }
}