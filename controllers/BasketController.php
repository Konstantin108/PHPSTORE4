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
        $idOfUsersOrder = '';
        if (is_array($goodsInBasket)) {
            foreach ($goodsInBasket as $item) {
                if (is_array($item)) {
                    foreach ($item as $key => $elem) {
                        if ($key == 'user_id')
                            $idOfUsersOrder = $elem;
                    }
                }

            }
        }
        $total = $this->totalAction();
        return $this->render(
            'basket',
            [
                'is_auth' => $is_auth,
                'user_name' => $userName,
                'user_is_admin' => $userIsAdmin,
                'goods_in_basket' => $goodsInBasket,
                'total' => $total,
                'user_id' => $userId,
                'id_of_users_order' => $idOfUsersOrder
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
        if ($_SESSION['usersOrderId']) {
            $userId = $this->getOrderId();
        } else {
            $userId = $_SESSION['user_true']['id'];
        }
        $id = $this->getId();
        $goodRepository = $this->container->goodRepository;
        $msg = $this->container->basketServices->plus($userId, $id, $goodRepository);
        $this->request->clearUsersOrderId();
        return $this->redirect('', $msg);
    }

    public function minusAction()
    {
        if ($_SESSION['usersOrderId']) {
            $userId = $this->getOrderId();
        } else {
            $userId = $_SESSION['user_true']['id'];
        }
        $id = $this->getId();
        $goodRepository = $this->container->goodRepository;
        $msg = $this->container->basketServices->minus($userId, $id, $goodRepository);
        $this->request->clearUsersOrderId();
        return $this->redirect('', $msg);
    }

    public function delFromBasketAction()
    {
        if ($_SESSION['usersOrderId']) {
            $userId = $this->getOrderId();
        } else {
            $userId = $_SESSION['user_true']['id'];
        }
        $id = $this->getId();
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
        $usersData = [];
        $arr = $_SESSION['goods'];
        $userRepository = $this->container->userRepository;
        if (is_array($arr)) {
            foreach ($arr as $key => $value) {
                $usersData[] = $userRepository->getOne($key);
            }
        }
        $users = [];
        foreach ($usersData as $value) {
            if ($_SESSION['goods'][$value->id]) {
                $users[] = $value;
            }
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
        $userId = $_SESSION['user_true']['id'];
        $idOfUsersOrder = '';
        if (is_array($goodsInBasket)) {
            foreach ($goodsInBasket as $item) {
                if (is_array($item)) {
                    foreach ($item as $key => $elem) {
                        if ($key == 'user_id')
                            $idOfUsersOrder = $elem;
                    }
                }

            }
        }
        return $this->render(
            'basket',
            [
                'is_auth' => $is_auth,
                'user_name' => $userName,
                'user_is_admin' => $userIsAdmin,
                'goods_in_basket' => $goodsInBasket,
                'total' => $total,
                'user' => $user,
                'user_id' => $userId,
                'id_of_users_order' => $idOfUsersOrder
            ]
        );
    }

    public function delOrderAction()
    {
        $is_auth = false;
        if ($_SESSION['user_true']['user']) {
            $is_auth = true;
        }
        $userName = $_SESSION['user_true']['name'];
        $userIsAdmin = $_SESSION['user_true']['is_admin'];
        $id = $this->request->getId();
        unset($_SESSION['goods'][$id]);
        unset($_SESSION['total'][$id]);
        return $this->redirect('', '', [
            'is_auth' => $is_auth,
            'user_name' => $userName,
            'user_is_admin' => $userIsAdmin,
        ]);
    }
}