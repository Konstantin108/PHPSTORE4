<?php

namespace app\controllers;

class BasketController extends Controller
{
    protected $actionDefault = 'index';

    /**
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\LoaderError
     */
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
        return $this->render(
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
        $goodRepository = $this->container->goodRepository;
        $msg = $this->container->basketServices->add($userId, $id, $goodRepository);
        return $this->redirect('', $msg);
    }

    public function plusAction()
    {
        $userId = $_SESSION['user_true']['id'];
        $id = $this->getId();
        $goodRepository = $this->container->goodRepository;
        $msg = $this->container->basketServices->plus($userId, $id, $goodRepository);
        return $this->redirect('', $msg);
    }

    public function minusAction()
    {
        $userId = $_SESSION['user_true']['id'];
        $id = $this->getId();
        $goodRepository = $this->container->goodRepository;
        $msg = $this->container->basketServices->minus($userId, $id, $goodRepository);
        return $this->redirect('', $msg);
    }

    public function delFromBasketAction()
    {
        $userId = $_SESSION['user_true']['id'];
        $id = $this->getId();
        $msg = $this->container->basketServices->del($userId, $id);
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