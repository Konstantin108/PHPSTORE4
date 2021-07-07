<?php

namespace app\controllers;

use app\repositories\GoodRepository;
use app\services\BasketServices;

class BasketController extends Controller
{
    protected $actionDefault = 'index';

    public function indexAction()
    {
        $is_auth = false;
        if ($_SESSION['user_true']['user']) {
            $is_auth = true;
        }
        $userName = $_SESSION['user_true']['name'];
        $userIsAdmin = $_SESSION['user_true']['is_admin'];
        $userId = $_SESSION['user_true']['id'];
        $goodsInBasket = $_SESSION['goods'][$userId];
        $total = $this->totalAction();
        return $this->renderer->render(
            'basket',
            [
                'is_auth' => $is_auth,
                'user_name' => $userName,
                'user_is_admin' => $userIsAdmin,
                'goods_in_basket' => $goodsInBasket,
                'total' => $total
            ]
        );
    }

    public function addAction()
    {
        $userId = $_SESSION['user_true']['id'];
        $id = $this->getId();
        $goodRepository = new GoodRepository();
        $msg = (new BasketServices())->add($userId, $id, $goodRepository);
        return $this->redirect('', $msg);
    }

    public function totalAction()
    {
        $userId = $_SESSION['user_true']['id'];
        $arr = $_SESSION['goods'][$userId];
        $total = null;
        if (is_array($arr)) {
            foreach ($arr as $item) {
                foreach ($item as $key => $price) {
                    if ($key == 'price') {
                        $total += $price;
                    }
                }
            }
        }
        return $_SESSION['total'][$userId] = $total;
    }
}