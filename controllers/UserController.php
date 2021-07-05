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
        $newFileName = $_POST['avatar'];

        if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == '/user/update') {
        }
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['avatar']['tmp_name'];
            $fileName = $_FILES['avatar']['name'];
            $fileSize = $_FILES['avatar']['size'];
            $fileType = $_FILES['avatar']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $uploadFileDir = '../public/img/';
            $dest_path = $uploadFileDir . $newFileName;
            if (move_uploaded_file($fileTmpPath, $dest_path)) {

            };
        } else {
            $thisId = $this->getId();
            $user = (new UserRepository())->getOne($thisId);
            if ($user->avatar) {
                $newFileName = $user->avatar;
                $uploadFileDir = '../public/img/';
                $dest_path = $uploadFileDir . $newFileName;
            }
        }

        $user = new User();
        $user->id = $id;
        $user->login = $login;
        $user->password = $password;
        $user->name = $name;
        $user->position = $position;
        $user->avatar = $newFileName;

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
        if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == '/user/upload/') {
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
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                var_dump('файл перемещен');
            }
        }
    }

    public function getLink()
    {
        static $link;
        if (empty($link)) {
            $link = mysqli_connect('127.0.0.1', 'root', 'root', 'gbphp');
        }
        return $link;
    }

    public function authAction()
    {
        $is_auth = false;
        if ($_SESSION['user']) {
            $is_auth = true;
        }
        $userLogin = $_SESSION['user'];
        $userId = $_SESSION['id'];
        $userName = $_SESSION['name'];
        $userIsAdmin = $_SESSION['is_admin'];
        $userPosition = $_SESSION['position'];
        $userAvatar = $_SESSION['avatar'];
        return $this->renderer->render(
            'auth',
            [
                'is_auth' => $is_auth,
                'user_login' => $userLogin,
                'user_id' => $userId,
                'user_name' => $userName,
                'user_is_admin' => $userIsAdmin,
                'user_position' => $userPosition,
                'user_avatar' => $userAvatar
            ]);
    }

    public function getAuthAction()
    {
        if (empty($_POST['login']) || empty($_POST['password'])) {
            header('Location: /user/auth');
            return '';
        } else {

            $login = $_POST['login'];
            $password = $_POST['password'];

            $sqlAllUsers = "SELECT login FROM users";
            $resultAllUsers = mysqli_query($this->getLink(), $sqlAllUsers);
            $allUsersData = mysqli_fetch_all($resultAllUsers);

            $arr = [];

            foreach ($allUsersData as $item) {
                foreach ($item as $data) {
                    $arr[] = $data;
                }
            }

            if (in_array($login, $arr)) {

                $sql = "SELECT login, password FROM users WHERE login = '{$login}'";   //<--создание запроса к БД
                $result = mysqli_query($this->getLink(), $sql);    //<--отправка запроса к БД и запись результата запроса в переменную
                $userData = mysqli_fetch_assoc($result);    //<--обработка результата запроса

                $sqlAllData = "SELECT id, name, is_admin, position, avatar FROM users WHERE login = '{$login}'";   //<--создание запроса к БД(поиск имени)
                $resultAllData = mysqli_query($this->getLink(), $sqlAllData);
                $allData = mysqli_fetch_assoc($resultAllData);

                $dataId = '';
                $dataName = '';
                $dataIsAdmin = '';
                $dataPosition = '';
                $dataAvatar = '';

                foreach ($allData as $item => $data) {
                    if ($item == 'id') {
                        $dataId = $data;
                    } elseif ($item == 'name') {
                        $dataName = $data;
                    } elseif ($item == 'is_admin') {
                        $dataIsAdmin = $data;
                    } elseif ($item == 'position') {
                        $dataPosition = $data;
                    } elseif ($item == 'avatar') {
                        $dataAvatar = $data;
                    }
                }

                if (!empty($userData) && password_verify($password, $userData['password'])) {    //<--верификация хэша пароля
                    $_SESSION['user'] = $login;
                    $_SESSION['id'] = $dataId;
                    $_SESSION['name'] = $dataName;
                    $_SESSION['is_admin'] = $dataIsAdmin;
                    $_SESSION['position'] = $dataPosition;
                    $_SESSION['avatar'] = $dataAvatar;
                }

                header('Location: /user/auth');
                return '';
            } else {
                header('Location: /user/auth');
                return '';
            }
        }
    }

    public function outAction()
    {
        session_destroy();
        header('Location: /user/auth');
    }

    public function showSessionAction()
    {
        var_dump($_SESSION);
    }
}