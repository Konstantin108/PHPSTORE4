<?php

namespace app\controllers;

use app\entities\Good;

class GoodController extends Controller
{

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    public function allAction()
    {
        $goods = $this->container->goodRepository->getAll();
        $this->request->clearMsg();
        $this->request->clearUsersOrderId();
        $is_auth = false;
        if ($_SESSION['user_true']['user']) {
            $is_auth = true;
        }
        $userName = $_SESSION['user_true']['name'];
        $userIsAdmin = $_SESSION['user_true']['is_admin'];
        $total = $this->container->basketServices->total();
        return $this->render(
            'goodAll',
            [
                'goods' => $goods,
                'is_auth' => $is_auth,
                'user_name' => $userName,
                'user_is_admin' => $userIsAdmin,
                'total' => $total
            ]);
    }

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    public function oneAction()
    {
        $this->request->clearUsersOrderId();
        $id = $this->getId();
        $good = $this->container->goodRepository->getOne($id);
        $is_auth = false;
        $msg = $_SESSION['msg'];
        if ($_SESSION['user_true']['user']) {
            $is_auth = true;
        }
        $userId = $_SESSION['user_true']['id'];
        $userName = $_SESSION['user_true']['name'];
        $userIsAdmin = $_SESSION['user_true']['is_admin'];
        $col = $_SESSION['goods'][$userId][$id]['counter'];
        $price = $_SESSION['goods'][$userId][$id]['price'];

        $comments = $this->container->commentRepository->getAll();

        return $this->render(
            'goodOne',
            [
                'good' => $good,
                'user_id' => $userId,
                'is_auth' => $is_auth,
                'user_name' => $userName,
                'user_is_admin' => $userIsAdmin,
                'msg' => $msg,
                'col' => $col,
                'price' => $price,
                'comments' => $comments
            ]);
    }

    /**
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\LoaderError
     */
    public function editAction()
    {
        $id = $this->getId();
        $good = $this->container->goodRepository->getOne($id);
        $this->request->clearMsg();
        $this->request->clearUsersOrderId();
        $is_auth = false;
        if ($_SESSION['user_true']['user']) {
            $is_auth = true;
        }
        $userName = $_SESSION['user_true']['name'];
        $userIsAdmin = $_SESSION['user_true']['is_admin'];
        if ($_SERVER['REQUEST_METHOD'] = 'POST') {
            return $this->render(
                'goodEdit',
                [
                    'good' => $good,
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
        $id = $_POST['id'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $info = $_POST['info'];
        $counter = 1;
        $newFileName = $_POST['img'];

        $is_auth = false;
        if ($_SESSION['user_true']['user']) {
            $is_auth = true;
        }
        $userName = $_SESSION['user_true']['name'];
        $userIsAdmin = $_SESSION['user_true']['is_admin'];

        if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == '/good/update') {
        }
        if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['img']['tmp_name'];
            $fileName = $_FILES['img']['name'];
            $fileSize = $_FILES['img']['size'];
            $fileType = $_FILES['img']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $uploadFileDir = '../public/img/';
            $dest_path = $uploadFileDir . $newFileName;
            if (move_uploaded_file($fileTmpPath, $dest_path)) {

            };
        } else {
            $thisId = $this->getId();
            $good = $this->container->goodRepository->getOne($thisId);
            if ($good->avatar) {
                $newFileName = $good->img;
                $uploadFileDir = '../public/img/';
                $dest_path = $uploadFileDir . $newFileName;
            }
        }

        $good = new Good();
        $good->id = $id;
        $good->name = $name;
        $good->price = $price;
        $good->info = $info;
        $good->counter = $counter;
        $good->img = $newFileName;

        if ($userIsAdmin) {

            $goods = $_SESSION['goods'];
            $arr = [];
            if (is_array($goods)) {
                foreach ($goods as $key => $item) {
                    $arr[] = $key;
                }
                foreach ($arr as $item) {
                    unset($_SESSION['goods'][$item][$id]);
                }
            }

            if (!empty($name) &&
                !empty($price) &&
                !empty($info)
            ) {
                $this->container->goodRepository->save($good);
                header('Location: /');
                return '';
            } else {
                return $this->render(
                    'emptyFields',
                    [
                        'good' => $good,
                        'is_auth' => $is_auth,
                        'user_name' => $userName,
                        'user_is_admin' => $userIsAdmin,
                    ]);
            }
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
    public function delAction()
    {
        $id = $this->getId();
        $good = $this->container->goodRepository->getOne($id);
        $this->request->clearMsg();
        $this->request->clearUsersOrderId();
        $is_auth = false;
        if ($_SESSION['user_true']['user']) {
            $is_auth = true;
        }
        $total = $this->container->basketServices->total();
        $userName = $_SESSION['user_true']['name'];
        $userIsAdmin = $_SESSION['user_true']['is_admin'];
        if ($_SERVER['REQUEST_METHOD'] = 'POST') {
            return $this->render(
                'goodDel',
                [
                    'good' => $good,
                    'is_auth' => $is_auth,
                    'user_name' => $userName,
                    'user_is_admin' => $userIsAdmin,
                    'total' => $total
                ]);
        }
    }

    /**
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\LoaderError
     */
    public function getDelAction()
    {
        $is_auth = false;
        if ($_SESSION['user_true']['user']) {
            $is_auth = true;
        }
        $userName = $_SESSION['user_true']['name'];

        $id = $this->getId();
        $good = new Good();
        $good->id = $id;
        $this->request->clearUsersOrderId();
        $userIsAdmin = $_SESSION['user_true']['is_admin'];
        $goods = $_SESSION['goods'];
        $arr = [];
        $total = $this->container->basketServices->total();

        if ($userIsAdmin) {

            if (is_array($goods)) {
                foreach ($goods as $key => $item) {
                    $arr[] = $key;
                }
                foreach ($arr as $item) {
                    unset($_SESSION['goods'][$item][$id]);
                }
            }

            $this->container->goodRepository->delete($good);
            header('Location: /');
            return '';
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