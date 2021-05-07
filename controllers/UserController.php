<?php

namespace app\controllers;

use app\models\User;

class UserController
{
    protected $actionDefault = 'all';

    public function run($action)
    {
        if (empty($action)) {
            $action = $this->actionDefault;
        }

        $action .= "Action";

        if (!method_exists($this, $action)) {
            return '404';
        }
        return $this->$action();
    }

    public function allAction()
    {
        $users = User::getAll();
        return $this->render('userAll', ['users' => $users]);
    }

    public function oneAction()
    {
        $id = $this->getId();
        $user = User::getOne($id);
        return $this->render('userOne', ['user' => $user]);
    }

    public function editAction()
    {
        $id = $this->getId();
        $user = User::getOne($id);
        return $this->render('userEdit', ['user' => $user]);
    }

    public function updateAction()
    {
        /** @var User $user */
        $id = $_POST['id'];
        $login = $_POST['login'];
        $password = $_POST['password'];
        $name = $_POST['name'];
        $is_admin = $_POST['is_admin'];
        $position = $_POST['position'];

        $user = new User();
        $user->id = $id;
        $user->login = $login;
        $user->password = $password;
        $user->name = $name;
        $user->position = $position;

        switch($is_admin){
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

        if(!empty($login) &&
            !empty($name) &&
            !empty($password) &&
            !empty($position)
            ){
            $user->save();
            header('Location: /');
            return '';
        }else{
            return $this->render('emptyFields', ['user' => $user]);
        }
    }

    public function delAction()
    {
        $id = $this->getId();
        $user = User::getOne($id);
        return $this->render('userDel', ['user' => $user]);
    }

    public function getDelAction()
    {
        $id = $this->getId();
        $user = User::getOne($id);
        $user->delete();
        header('Location: /');
        return '';
    }

    public function render($template, $params = [])
    {
        $content = $this->renderTmpl($template, $params);
        return $this->renderTmpl(
            'layouts/main',
            [
                'content' => $content
            ]
        );
    }

    public function renderTmpl($template, $params = [])
    {
        extract($params);
        ob_start();
        include dirname(__DIR__) . '/views/' . $template . '.php';
        return ob_get_clean();
    }

    protected function getId()
    {
        if(empty($_GET['id'])){
            return 0;
        }
        return (int)$_GET['id'];
    }
}