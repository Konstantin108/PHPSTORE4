<?php

namespace app\main;

use app\services\TwigRenderServices;
use app\traits\SingletonTrait;

class App
{
    use SingletonTrait;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var Container
     */
    protected $container;

    /**
     * @return self
     */
    public static function call()
    {
        return static::getInstance();
    }

    public function run($config)
    {
        $this->container = new Container($config['components']);
        $this->config = $config['defaultController'];
        $this->runController();
    }

    private function runController()
    {
        $request = new \app\services\Request();

        $controllerName = 'good';     //<-- получение контроллера
        if (!empty($request->getActionName())) {
            $controllerName = $request->getControllerName();
        }

        $controllerClass = 'app\\controllers\\' . ucfirst($controllerName) . 'Controller';     //<-- создаём название класса контроллера

        if (class_exists($controllerClass)) {
            $controller = new $controllerClass($request, $this->container);
            echo $controller->run($request->getActionName());
        } else {
            echo '404';
        }
    }
}