<?php

namespace app\controllers;

use app\entities\Good;
use app\repositories\GoodRepository;

class GoodController extends Controller
{

    public function allAction()
    {
        $goods = (new GoodRepository())->getAll();
        $this->request->clearMsg();
        $is_auth = false;
        if ($_SESSION['user_true']['user']) {
            $is_auth = true;
        }
        $userName = $_SESSION['user_true']['name'];
        $userIsAdmin = $_SESSION['user_true']['is_admin'];
        return $this->renderer->render(
            'goodAll',
            [
                'goods' => $goods,
                'is_auth' => $is_auth,
                'user_name' => $userName,
                'user_is_admin' => $userIsAdmin,
            ]);
    }

    public function oneAction()
    {
        $id = $this->getId();
        $good = (new GoodRepository())->getOne($id);
        $is_auth = false;
        $msg = $_SESSION['msg'];
        if ($_SESSION['user_true']['user']) {
            $is_auth = true;
        }
        $userId = $_SESSION['user_true']['id'];
        $userName = $_SESSION['user_true']['name'];
        $userIsAdmin = $_SESSION['user_true']['is_admin'];
        return $this->renderer->render(
            'goodOne',
            [
                'good' => $good,
                'user_id' => $userId,
                'is_auth' => $is_auth,
                'user_name' => $userName,
                'user_is_admin' => $userIsAdmin,
                'msg' => $msg
            ]);
    }

    public function editAction()
    {
        $id = $this->getId();
        $good = (new GoodRepository())->getOne($id);
        $this->request->clearMsg();
        $is_auth = false;
        if ($_SESSION['user_true']['user']) {
            $is_auth = true;
        }
        $userName = $_SESSION['user_true']['name'];
        $userIsAdmin = $_SESSION['user_true']['is_admin'];
        if ($_SERVER['REQUEST_METHOD'] = 'POST') {
            return $this->renderer->render(
                'goodEdit',
                [
                    'good' => $good,
                    'is_auth' => $is_auth,
                    'user_name' => $userName,
                    'user_is_admin' => $userIsAdmin,
                ]);
        }
    }

    public function updateAction()
    {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $info = $_POST['info'];
        $counter = 1;
        $newFileName = $_POST['img'];

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
            $good = (new GoodRepository())->getOne($thisId);
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

        if (!empty($name) &&
            !empty($price) &&
            !empty($info)
        ) {
            (new GoodRepository())->save($good);
            header('Location: /');
            return '';
        } else {
            return $this->renderer->render(
                'emptyFields',
                [
                    'good' => $good
                ]);
        }
    }

    public function delAction()
    {
        $id = $this->getId();
        $good = (new GoodRepository())->getOne($id);
        $this->request->clearMsg();
        $is_auth = false;
        if ($_SESSION['user_true']['user']) {
            $is_auth = true;
        }
        $userName = $_SESSION['user_true']['name'];
        $userIsAdmin = $_SESSION['user_true']['is_admin'];
        if ($_SERVER['REQUEST_METHOD'] = 'POST') {
            return $this->renderer->render(
                'goodDel',
                [
                    'good' => $good,
                    'is_auth' => $is_auth,
                    'user_name' => $userName,
                    'user_is_admin' => $userIsAdmin,
                ]);
        }
    }

    public function getDelAction()
    {
        $id = $this->getId();
        $good = new Good();
        $good->id = $id;

        $goods = $_SESSION['goods'];
        $arr = [];
        foreach ($goods as $key => $item) {
            $arr[] = $key;
        }
        foreach ($arr as $item) {
            unset($_SESSION['goods'][$item][$id]);
        }

        (new GoodRepository())->delete($good);
        header('Location: /');
        return '';
    }
}