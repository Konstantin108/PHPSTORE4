<?php

namespace app\controllers;

use app\services\RenderI;
use app\services\Request;

abstract class Controller
{
    protected $actionDefault = 'all';

    /**
     * @var RenderI
     */
    protected $renderer;

    /**
     * @var Request
     */
    protected $request;

    /**
     * Controller constructor.
     * @param RenderI $renderer
     * @param Request $request
     */
    public function __construct(RenderI $renderer, Request $request)
    {
        $this->renderer = $renderer;
        $this->request = $request;
    }

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

    /**
     * @return int
     */
    protected function getId()
    {
        return $this->request->getId();
    }

    protected function redirect($path = '', $msg = '')
    {
        if (!empty($msg)) {
            $_SESSION['msg'] = $msg;
        }
        if (empty($path)) {
            if (empty($_SERVER['HTTP_REFERER'])) {
                $path = '/';
            } else {
                $path = $_SERVER['HTTP_REFERER'];
            }
        }
        header('Location: ' . $path);
        return '';
    }
}
