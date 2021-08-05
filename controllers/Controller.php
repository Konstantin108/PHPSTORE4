<?php

namespace app\controllers;

use app\main\Container;
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
     * @var Container
     */
    protected $container;

    /**
     * Controller constructor.
     * @param RenderI $renderer
     * @param Request $request
     * @param Container $container
     */
    public function __construct(Request $request, Container $container)
    {
        $this->container = $container;
        $this->request = $request;
    }

    /**
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\LoaderError
     */
    public function run($action)
    {
        if (empty($action)) {
            $action = $this->actionDefault;
        }

        $action .= "Action";
        $path = '';

        if (empty($path)) {
            if (empty($_SERVER['HTTP_REFERER'])) {
                $path = '/';
            } else {
                $path = $_SERVER['HTTP_REFERER'];
            }
        }

        if (!method_exists($this, $action)) {
            return $this->render(
                'badRequest',
                [
                    'path' => $path
                ]);
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

    /**
     * @return int
     */
    protected function getOrderId()
    {
        return $this->request->getOrderId();
    }

    /**
     * @return int
     */
    protected function getCommentId()
    {
        return $this->request->getCommentId();
    }

    /**
     * @return int
     */
    protected function getUserId()
    {
        return $this->request->getUserId();
    }

    /**
     * @return int
     */
    protected function getThisUserId()
    {
        return $this->request->thisUserId();
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

    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    protected function render($template, $params = [])
    {
        return $this->container->renderer->render($template, $params);
    }
}
