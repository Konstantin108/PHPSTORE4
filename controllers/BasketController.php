<?php

namespace app\controllers;

class BasketController extends Controller
{
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
        if (!$idOfUsersOrder) {
            $idOfUsersOrder = $userId = $_SESSION['user_true']['id'];
        }
        $total = $this->container->basketServices->total();
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

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    public function addAction()
    {
        $this->request->clearUsersOrderId();
        $userId = $_SESSION['user_true']['id'];
        $is_auth = false;
        if ($_SESSION['user_true']['user']) {
            $is_auth = true;
        }
        $userName = $_SESSION['user_true']['name'];
        $userIsAdmin = $_SESSION['user_true']['is_admin'];
        if ($userId) {
            $id = $this->getId();
            $goodRepository = $this->container->goodRepository;
            $msg = $this->container->basketServices->add($userId, $id, $goodRepository);
            $this->request->clearUsersOrderId();
            $total = $this->container->basketServices->total();
            return $this->redirect('', $msg);
        } else {
            return $this->render(
                'basket',
                [
                    'is_auth' => $is_auth,
                    'user_name' => $userName,
                    'user_is_admin' => $userIsAdmin,
                    'user_id' => $userId,
                ]);
        }
    }

    public function plusAction()
    {
        $is_auth = false;
        if ($_SESSION['user_true']['user']) {
            $is_auth = true;
        }
        $userName = $_SESSION['user_true']['name'];
        $userIsAdmin = $_SESSION['user_true']['is_admin'];
        if ($_SESSION['usersOrderId']) {
            $userId = $this->getOrderId();
        } else {
            $userId = $_SESSION['user_true']['id'];
        }
        if ($userId) {
            $total = $this->container->basketServices->total();
            $id = $this->getId();
            $goodRepository = $this->container->goodRepository;
            $msg = $this->container->basketServices->plus($userId, $id, $goodRepository);
            $this->request->clearUsersOrderId();
            return $this->redirect('', $msg);
        } else {
            return $this->render(
                'basket',
                [
                    'is_auth' => $is_auth,
                    'user_name' => $userName,
                    'user_is_admin' => $userIsAdmin,
                    'user_id' => $userId,
                ]);
        }
    }

    public function minusAction()
    {
        $is_auth = false;
        if ($_SESSION['user_true']['user']) {
            $is_auth = true;
        }
        $userName = $_SESSION['user_true']['name'];
        $userIsAdmin = $_SESSION['user_true']['is_admin'];
        if ($_SESSION['usersOrderId']) {
            $userId = $this->getOrderId();
        } else {
            $userId = $_SESSION['user_true']['id'];
        }
        if ($userId) {
            $total = $this->container->basketServices->total();
            $id = $this->getId();
            $goodRepository = $this->container->goodRepository;
            $msg = $this->container->basketServices->minus($userId, $id, $goodRepository);
            $this->request->clearUsersOrderId();
            return $this->redirect('', $msg);
        } else {
            return $this->render(
                'basket',
                [
                    'is_auth' => $is_auth,
                    'user_name' => $userName,
                    'user_is_admin' => $userIsAdmin,
                    'user_id' => $userId,
                ]);
        }
    }

    public function delFromBasketAction()
    {
        $is_auth = false;
        if ($_SESSION['user_true']['user']) {
            $is_auth = true;
        }
        $userName = $_SESSION['user_true']['name'];
        $userIsAdmin = $_SESSION['user_true']['is_admin'];
        if ($_SESSION['usersOrderId']) {
            $userId = $this->getOrderId();
        } else {
            $userId = $_SESSION['user_true']['id'];
        }
        $id = $this->getId();
        $goodId = $_SESSION['goods'][$userId][$id]['user_id'] == $userId;
        if ($userId && $goodId == $userId) {
            $total = $this->container->basketServices->total();
            $msg = $this->container->basketServices->del($userId, $id);
            $this->request->clearUsersOrderId();
            return $this->redirect('', $msg);
        } else {
            return $this->render(
                'basket',
                [
                    'is_auth' => $is_auth,
                    'user_name' => $userName,
                    'user_is_admin' => $userIsAdmin,
                    'user_id' => $userId,
                ]);
        }
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

        $totalKey = $_SESSION['total'];
        $userTotal = [];
        if (is_array($userTotal)) {
            foreach ($totalKey as $key => $value) {
                $userTotal[$key] = $value;
            }
        }

        $countData = [];
        foreach ($usersData as $value) {
            $countData[$value->id] = $_SESSION['goods'][$value->id];

        }

        $counterOfUsers = [];
        foreach ($countData as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $int => $elem) {
                    if (is_array($elem)) {
                        foreach ($elem as $name => $data) {
                            if ($name == 'counter') {
                                $counterOfUsers[$key] += $data;
                            }
                        }
                    }
                }
            }
        }
        $total = $this->container->basketServices->total();
        return $this->render(
            'orders',
            [
                'is_auth' => $is_auth,
                'user_name' => $userName,
                'user_is_admin' => $userIsAdmin,
                'users' => $users,
                'user_total' => $userTotal,
                'counter_of_users' => $counterOfUsers,
                'total' => $total
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
        $total = $this->container->basketServices->total();
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
        if ($userIsAdmin) {

            unset($_SESSION['goods'][$id]);
            unset($_SESSION['total'][$id]);
            return $this->redirect('', '', [
                'is_auth' => $is_auth,
                'user_name' => $userName,
                'user_is_admin' => $userIsAdmin,
            ]);
        } else {
            return $this->render(
                'fail',
                [
                    'is_auth' => $is_auth,
                    'user_name' => $userName,
                    'user_is_admin' => $userIsAdmin,
                ]);
        }
    }
}