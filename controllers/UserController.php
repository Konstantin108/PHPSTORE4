<?php

namespace app\controllers;

use app\entities\User;
use app\repositories\UserRepository;

class UserController extends Controller
{

    public function allAction()
    {
        $users = (new UserRepository())->getAll();

        return $this->renderer->render(
            'userAll',
            [
                'users' => $users
            ]);
    }

    public function oneAction()
    {
        $id = $this->getId();
        $user = (new UserRepository())->getOne($id);
        return $this->renderer->render(
            'userOne',
            [
                'user' => $user
            ]);
    }

    public function editAction()
    {
        $id = $this->getId();
        $user = (new UserRepository())->getOne($id);
        if ($_SERVER['REQUEST_METHOD'] = 'POST') {
            return $this->renderer->render(
                'userEdit',
                [
                    'user' => $user
                ]);
        }
    }

    public function updateAction()
    {
        $id = $_POST['id'];
        $login = $_POST['login'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $name = $_POST['name'];
        $is_admin = $_POST['is_admin'];
        $position = $_POST['position'];

        $user = new User();
        $user->id = $id;
        $user->login = $login;
        $user->password = $password;
        $user->name = $name;
        $user->position = $position;

        switch ($is_admin) {
            case 'yes':
                $is_admin = 2;
                break;
            case 'no';
                $is_admin = 0;
                break;
            default:
                $is_admin = 0;
                break;
        }
        $user->is_admin = $is_admin;

        if (!empty($login) &&
            !empty($name) &&
            !empty($password) &&
            !empty($position)
        ) {
            (new UserRepository())->save($user);
            header('Location: /');
            return '';
        } else {
            return $this->renderer->render(
                'emptyFields',
                [
                    'user' => $user
                ]);
        }
    }

    public function delAction()
    {
        $id = $this->getId();
        $user = (new UserRepository())->getOne($id);
        if ($_SERVER['REQUEST_METHOD'] = 'POST') {
            return $this->renderer->render(
                'userDel',
                [
                    'user' => $user
                ]);
        }
    }

    /**
     * @return string
     */
    public function getDelAction()
    {
        $id = $this->getId();
        $user = new User();
        $user->id = $id;
        (new UserRepository())->delete($user);
        header('Location: /');
        return '';
    }

    public function addImgAction()
    {
        return $this->renderer->render('addImg');
    }

    public function uploadAction()
    {
        if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == '/user/upload/'){
            var_dump('кнопка нажата');
        }
        if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK) {
            var_dump('загружено успешно');
            $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
            $fileName = $_FILES['uploadedFile']['name'];
            $fileSize = $_FILES['uploadedFile']['size'];
            $fileType = $_FILES['uploadedFile']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $uploadFileDir = '../public/img/';
            $dest_path = $uploadFileDir . $newFileName;
            if(move_uploaded_file($fileTmpPath, $dest_path))
            {
                var_dump('файл перемещен');
            }
        }
    }
}