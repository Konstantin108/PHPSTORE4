<?php

namespace app\controllers;

use app\models\User;

class UserController extends Controller
{

    public function allAction()
    {
        $users = User::getAll();
        return $this->renderer->render(
            'userAll',
            [
                'users' => $users
            ]);
    }

    public function oneAction()
    {
        $id = $this->getId();
        $user = User::getOne($id);
        return $this->renderer->render(
            'userOne',
            [
                'user' => $user
            ]);
    }

    public function editAction()
    {
        $id = $this->getId();
        $user = User::getOne($id);
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
        /** @var User $user */
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
            $user->save();
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
        $user = User::getOne($id);
        if ($_SERVER['REQUEST_METHOD'] = 'POST') {
            return $this->renderer->render(
                'userDel',
                [
                    'user' => $user
                ]);
        }
    }

    public function getDelAction()
    {
        $id = $this->getId();
        $user = User::getOne($id);
        $user->delete();
        header('Location: /');
        return '';
    }
}