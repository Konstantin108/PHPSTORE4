<?php

namespace app\controllers;

use app\entities\User;

class UserController extends Controller
{

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    public function allAction()
    {
        $users = $this->container->userRepository->getAll();
        $this->request->clearMsg();
        $this->request->clearUsersOrderId();
        $is_auth = false;
        if ($_SESSION['user_true']['user']) {
            $is_auth = true;
        }
        $userName = $_SESSION['user_true']['name'];
        $userIsAdmin = $_SESSION['user_true']['is_admin'];
        return $this->render(
            'userAll',
            [
                'users' => $users,
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
    public function oneAction()
    {
        $id = $this->getId();
        $user = $this->container->userRepository->getOne($id);
        $this->request->clearMsg();
        $this->request->clearUsersOrderId();
        $is_auth = false;
        if ($_SESSION['user_true']['user']) {
            $is_auth = true;
        }
        $userName = $_SESSION['user_true']['name'];
        $userIsAdmin = $_SESSION['user_true']['is_admin'];
        return $this->render(
            'userOne',
            [
                'user' => $user,
                'is_auth' => $is_auth,
                'user_name' => $userName,
                'user_is_admin' => $userIsAdmin,
            ]);
    }

    /**
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\LoaderError
     */
    public function editAction()
    {
        $this->request->clearUsersOrderId();
        $id = $this->getId();
        $user = $this->container->userRepository->getOne($id);
        $this->request->clearMsg();
        $is_auth = false;
        if ($_SESSION['user_true']['user']) {
            $is_auth = true;
        }
        $userName = $_SESSION['user_true']['name'];
        $userIsAdmin = $_SESSION['user_true']['is_admin'];
        if ($_SERVER['REQUEST_METHOD'] = 'POST') {
            return $this->render(
                'userEdit',
                [
                    'user' => $user,
                    'is_auth' => $is_auth,
                    'user_name' => $userName,
                    'user_is_admin' => $userIsAdmin,
                ]);
        }
    }

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    public function updateAction()
    {
        $is_auth = false;
        if ($_SESSION['user_true']['user']) {
            $is_auth = true;
        }
        $userName = $_SESSION['user_true']['name'];
        $userIsAdmin = $_SESSION['user_true']['is_admin'];

        $id = $_POST['id'];
        $login = $_POST['login'];
        if (!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        } else {
            $password = '';
        }
        $name = $_POST['name'];
        $is_admin = $_POST['is_admin'];
        $position = $_POST['position'];
        $newFileName = $_POST['avatar'];

        $link = $this->container->db->getLink();
        if ($id) {
            $sqlAllUsers = "SELECT login FROM users WHERE id !=" . $id;
        } else {
            $sqlAllUsers = "SELECT login FROM users";
        }
        $resultAllUsers = mysqli_query($link, $sqlAllUsers);
        $allUsersData = mysqli_fetch_all($resultAllUsers);

        $arr = [];

        foreach ($allUsersData as $item) {
            foreach ($item as $data) {
                $arr[] = $data;
            }
        }

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
            $user = $this->container->userRepository->getOne($thisId);
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

        if (in_array($login, $arr)) {
            return $this->render(
                'authFail',
                [
                    'user' => $user,
                    'is_auth' => $is_auth,
                    'user_name' => $userName,
                    'user_is_admin' => $userIsAdmin,
                ]);
        }

        if (!empty($login) &&
            !empty($name) &&
            !empty($password) &&
            !empty($position)
        ) {
            $this->container->userRepository->save($user);
            if ($is_auth == true) {
                header('Location: /user/all');
            } else {
                header('Location: /user/auth');
            }
            return '';
        } else {
            return $this->render(
                'emptyFields',
                [
                    'user' => $user,
                    'is_auth' => $is_auth,
                    'user_name' => $userName,
                    'user_is_admin' => $userIsAdmin,
                ]);
        }
    }

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    public function delAction()
    {
        $id = $this->getId();
        $user = $this->container->userRepository->getOne($id);
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
                'userDel',
                [
                    'user' => $user,
                    'is_auth' => $is_auth,
                    'user_name' => $userName,
                    'user_is_admin' => $userIsAdmin,
                ]);
        }
    }

    /**
     * @return string
     */
    public function getDelAction()
    {
        $is_auth = false;
        if ($_SESSION['user_true']['user']) {
            $is_auth = true;
        }
        $userName = $_SESSION['user_true']['name'];

        $this->request->clearUsersOrderId();
        $id = $this->getId();
        $user = new User();
        $user->id = $id;

        $userIsAdmin = $_SESSION['user_true']['is_admin'];
        if ($userIsAdmin) {

            unset($_SESSION['goods'][$id]);
            unset($_SESSION['total'][$id]);

            $this->container->userRepository->delete($user);
            header('Location: /user/all');
            return '';
        } else {
            return $this->render(
                'fail',
                [
                    'user' => $user,
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
    public function authAction()
    {
        $this->request->clearMsg();
        $this->request->clearUsersOrderId();
        $is_auth = false;
        if ($_SESSION['user_true']['user']) {
            $is_auth = true;
        }
        $userLogin = $_SESSION['user_true']['user'];
        $userId = $_SESSION['user_true']['id'];
        $userName = $_SESSION['user_true']['name'];
        $userIsAdmin = $_SESSION['user_true']['is_admin'];
        $userPosition = $_SESSION['user_true']['position'];
        $userAvatar = $_SESSION['user_true']['avatar'];
        return $this->render(
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
            $link = $this->container->db->getLink();

            $sqlAllUsers = "SELECT login FROM users";
            $resultAllUsers = mysqli_query($link, $sqlAllUsers);
            $allUsersData = mysqli_fetch_all($resultAllUsers);

            $arr = [];

            foreach ($allUsersData as $item) {
                foreach ($item as $data) {
                    $arr[] = $data;
                }
            }

            if (in_array($login, $arr)) {

                $sql = "SELECT login, password FROM users WHERE login = '{$login}'";   //<--создание запроса к БД
                $result = mysqli_query($link, $sql);    //<--отправка запроса к БД и запись результата запроса в переменную
                $userData = mysqli_fetch_assoc($result);    //<--обработка результата запроса

                $sqlAllData = "SELECT id, name, is_admin, position, avatar FROM users WHERE login = '{$login}'";   //<--создание запроса к БД(поиск имени)
                $resultAllData = mysqli_query($link, $sqlAllData);
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
                    $_SESSION['user_true']['user'] = $login;
                    $_SESSION['user_true']['id'] = $dataId;
                    $_SESSION['user_true']['name'] = $dataName;
                    $_SESSION['user_true']['is_admin'] = $dataIsAdmin;
                    $_SESSION['user_true']['position'] = $dataPosition;
                    $_SESSION['user_true']['avatar'] = $dataAvatar;
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
        $this->request->outSession();
        $this->request->clearMsg();
        $this->request->clearUsersOrderId();
        header('Location: /user/auth');
    }

    public function showSessionAction()     //<-- показать сессию
    {
        $this->request->showSession();
    }

    public function clearSessionAction()     //<-- очистить сессию
    {
        $this->request->clearSession();
    }
}