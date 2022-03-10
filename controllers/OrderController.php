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

        $sessionCountArr = [];
        $sessionCount = $_SESSION['order'];
        foreach ($sessionCount as $value) {
            if (is_array($value)) {
                foreach ($value as $elem) {
                    if (is_array($elem)) {
                        foreach ($elem as $subElem) {
                            if (is_array($subElem)) {
                                foreach ($subElem as $subElem2) {
                                    if (is_array($subElem2)) {
                                        $sessionCountArr[] = $subElem2['user_id'];
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $userIdActual = [];
        $usersActual = $this->container->userRepository->getAll();
        foreach ($usersActual as $value) {
            if (is_object($value)) {
                $userIdActual[$value->id] = $value->id;
            }
        }

        foreach ($sessionCountArr as $elem) {
            if (!in_array($elem, $userIdActual)) {
                unset($_SESSION['order'][$elem]);
            }
        }

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
        $_SESSION['order'][$userId][$orderId]['status'] = 'ожидает подтверждения';

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

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    public function delOrderAction()
    {
        $this->request->clearMsg();
        $this->request->clearUsersOrderId();
        $is_auth = false;
        if ($_SESSION['user_true']['user']) {
            $is_auth = true;
        }
        $userName = $_SESSION['user_true']['name'];
        $userIsAdmin = $_SESSION['user_true']['is_admin'];

        $userId = $this->getUserId();
        $id = $this->getId();
        return $this->render(
            'purchaseDel',
            [
                'is_auth' => $is_auth,
                'user_name' => $userName,
                'user_is_admin' => $userIsAdmin,
                'user_id' => $userId,
                'id' => $id
            ]);
    }

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    public function getDelOrderAction()
    {
        $userIsAdmin = $_SESSION['user_true']['is_admin'];
        $is_auth = false;
        if ($_SESSION['user_true']['user']) {
            $is_auth = true;
        }
        $userName = $_SESSION['user_true']['name'];

        if ($userIsAdmin) {
            $userIdForDel = $this->getUserId();
            $idForDel = $this->getId();
            unset($_SESSION['order'][$userIdForDel][$idForDel]);
            $arr = $_SESSION['order'][$userIdForDel];
            if (count($arr) < 1) {
                unset($_SESSION['order'][$userIdForDel]);
            }
            $this->request->clearUsersOrderId();

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

    /**
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\LoaderError
     */
    public function updateAction()
    {
        $userId = $_SESSION['user_true']['id'];
        $is_auth = false;
        if ($_SESSION['user_true']['user']) {
            $is_auth = true;
        }
        $userName = $_SESSION['user_true']['name'];
        $userIsAdmin = $_SESSION['user_true']['is_admin'];

        $userIdForUpdate = $this->getUserId();
        $idForUpdate = $this->getId();
        if ($_POST['status']) {
            $status = $_POST['status'];
        } else {
            $status = $_SESSION['order'][$userIdForUpdate][$idForUpdate]['status'];
        }
        if ($userId) {
            $_SESSION['order'][$userIdForUpdate][$idForUpdate]['status'] = $status;
            return $this->redirect('', '');
        } else {
            return $this->render(
                'purchase',
                [
                    'is_auth' => $is_auth,
                    'user_name' => $userName,
                    'user_is_admin' => $userIsAdmin,
                    'user_id' => $userId,
                ]);
        }
    }
}