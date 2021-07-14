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
        $this->request->clearUsersOrderId();
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
        $this->request->clearUsersOrderId();
        $userId = $_SESSION['user_true']['id'];
        $id = $this->getId();
        $goodRepository = $this->container->goodRepository;
        $msg = $this->container->basketServices->add($userId, $id, $goodRepository);
        $this->request->clearUsersOrderId();
        return $this->redirect('', $msg);
    }

    public function plusAction()
    {
        $userId = $_SESSION['user_true']['id'];
        $id = $this->getId();
        $goodRepository = $this->container->goodRepository;
        $msg = $this->container->basketServices->plus($userId, $id, $goodRepository);
        $this->request->clearUsersOrderId();
        return $this->redirect('', $msg);
    }

    public function plusFromOrderAction()
    {
        $id = $_GET['id'];
        $userId = $_GET['order'];
        $goodRepository = $this->container->goodRepository;
        $msg = $this->container->basketServices->plus($userId, $id, $goodRepository);
        $this->request->clearUsersOrderId();
        return $this->redirect('', $msg);
    }

    public function minusAction()
    {
        $userId = $_SESSION['user_true']['id'];
        $id = $this->getId();
        $goodRepository = $this->container->goodRepository;
        $msg = $this->container->basketServices->minus($userId, $id, $goodRepository);
        $this->request->clearUsersOrderId();
        return $this->redirect('', $msg);
    }

    public function minusFromOrderAction()
    {
        $id = $_GET['id'];
        $userId = $_GET['order'];
        $goodRepository = $this->container->goodRepository;
        $msg = $this->container->basketServices->minus($userId, $id, $goodRepository);
        $this->request->clearUsersOrderId();
        return $this->redirect('', $msg);
    }

    public function delFromBasketAction()
    {
        $userId = $_SESSION['user_true']['id'];
        $id = $this->getId();
        $msg = $this->container->basketServices->del($userId, $id);
        $this->request->clearUsersOrderId();
        return $this->redirect('', $msg);
    }

    public function delFromOrderAction()
    {
        $id = $_GET['id'];
        $userId = $_GET['order'];
        $msg = $this->container->basketServices->del($userId, $id);
        $this->request->clearUsersOrderId();
        return $this->redirect('', $msg);
    }

    public function totalAction()
    {
        if ($_SESSION['usersOrderId']) {
            $userId = $_SESSION['usersOrderId'];
        } else {
            $userId = $_SESSION['user_true']['id'];
        }
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

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    public function ordersAction()
    {
        $this->request->clearUsersOrderId();
        $is_auth = false;
        if ($_SESSION['user_true']['user']) {
            $is_auth = true;
        }
        $userName = $_SESSION['user_true']['name'];
        $userIsAdmin = $_SESSION['user_true']['is_admin'];
        $users = [];
        $arr = $_SESSION['goods'];
        $userRepository = $this->container->userRepository;
        foreach ($arr as $key => $value) {
            $users[] = $userRepository->getOne($key);
        }
        return $this->render(
            'orders',
            [
                'is_auth' => $is_auth,
                'user_name' => $userName,
                'user_is_admin' => $userIsAdmin,
                'users' => $users
            ]
        );
    }

    /**
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\LoaderError
     */
    public function usersOrderAction()
    {
        $is_auth = false;
        if ($_SESSION['user_true']['user']) {
            $is_auth = true;
        }
        $usersOrderId = $this->getId();
        $this->request->clearUsersOrderId();
        $_SESSION['usersOrderId'] = $usersOrderId;
        $user = $this->container->userRepository->getOne($usersOrderId);
        $userName = $_SESSION['user_true']['name'];
        $userIsAdmin = $_SESSION['user_true']['is_admin'];
        $goodsInBasket = $_SESSION['goods'][$usersOrderId];
        $total = $this->totalAction();
        return $this->render(
            'basket',
            [
                'is_auth' => $is_auth,
                'user_name' => $userName,
                'user_is_admin' => $userIsAdmin,
                'goods_in_basket' => $goodsInBasket,
                'total' => $total,
                'user' => $user
            ]
        );
    }
}