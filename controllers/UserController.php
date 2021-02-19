<?php
namespace app\controllers;

class UserController
{
    protected $action;
    protected $actionDefault = 'all';

    public function run($action)
    {
        $this->action = $action;
        if(empty($this->action))
        {
            $action = $this->actionDefault;
        }

        $action .= "Action";

        if(method_exists($this, $this->action))
        {
            return '404';
        }
        return $this->$action();
    }

    public function allAction()
    {
        return 'все пользователи';
    }

    public function oneAction()
    {
        return 'пользователь';
    }
}