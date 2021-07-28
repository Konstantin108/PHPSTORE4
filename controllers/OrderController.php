<?php

namespace app\controllers;

class OrderController extends Controller
{
    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    public function indexAction()
    {
        $this->request->clearMsg();
        $this->request->clearUsersOrderId();
        $is_auth = false;
        if ($_SESSION['user_true']['user']) {
            $is_auth = true;
        }
        $userName = $_SESSION['user_true']['name'];
        $userIsAdmin = $_SESSION['user_true']['is_admin'];
        $otherUser = false;
        if ($this->getId()) {
            $userId = $this->getId();
            $otherUser = true;
        } else {
            $userId = $_SESSION['user_true']['id'];
        }
        $user = $this->container->userRepository->getOne($userId);
        $orders = $_SESSION['order'][$userId];

        $idOfUsers = '';
        if (is_array($orders)) {
            foreach ($orders as $item) {
                if (is_array($item)) {
                    foreach ($item as $key => $elem) {
                        if ($key == 'user_id')
                            $idOfUsers = $elem;
                    }
                }
            }
        }

        return $this->render(
            'purchase',
            [
                'is_auth' => $is_auth,
                'user_name' => $userName,
                'user_is_admin' => $userIsAdmin,
                'orders' => $orders,
                'user_id' => $userId,
                'other_user' => $otherUser,
                'user' => $user,
                'id_of_users' => $idOfUsers
            ]);
    }

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    public function purchaseAllAction()
    {
        $this->request->clearUsersOrderId();
        $is_auth = false;
        if ($_SESSION['user_true']['user']) {
            $is_auth = true;
        }
        $userName = $_SESSION['user_true']['name'];
        $userIsAdmin = $_SESSION['user_true']['is_admin'];

        $arr = $_SESSION['order'];
        $usersData = [];
        $userRepository = $this->container->userRepository;

        if (is_array($arr)) {
            foreach ($arr as $key => $item) {
                $usersData[] = $userRepository->getOne($key);
            }
        }
        $users = [];

        foreach ($usersData as $value) {
            if ($_SESSION['order'][$value->id]) {
                $count = count($_SESSION['order'][$value->id]);
                $users[$value->id] = $count;
            }
        }

        return $this->render(
            'purchaseAll',
            [
                'is_auth' => $is_auth,
                'user_name' => $userName,
                'user_is_admin' => $userIsAdmin,
                'users' => $users,
                'users_data' => $usersData
            ]);
    }

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    public function createOrderAction()
    {
        $this->request->clearMsg();
        $this->request->clearUsersOrderId();
        $is_auth = false;
        if ($_SESSION['user_true']['user']) {
            $is_auth = true;
        }
        $userName = $_SESSION['user_true']['name'];
        $userIsAdmin = $_SESSION['user_true']['is_admin'];

        $userId = $this->getOrderId();
        $basket = $_SESSION['goods'][$userId];
        $total = $_SESSION['total'][$userId];

        $_SESSION['countOfOrders'];

        if ($_SESSION['countOfOrders']) {
            $_SESSION['countOfOrders']++;
        } else {
            $_SESSION['countOfOrders'] = 1;
        }
        $orderId = $_SESSION['countOfOrders'];

        foreach ($basket as $key => $item) {
            $_SESSION['order'][$userId][$orderId][$key] = [$item];
        }

        $_SESSION['order'][$userId][$orderId]['total'] = $total;
        $_SESSION['order'][$userId][$orderId]['status'] = 'заказ в работе';

        unset($_SESSION['goods'][$userId]);
        unset($_SESSION['total'][$userId]);

        return $this->render(
            'doneOrder',
            [
                'is_auth' => $is_auth,
                'user_name' => $userName,
                'user_is_admin' => $userIsAdmin,
            ]);
    }
}