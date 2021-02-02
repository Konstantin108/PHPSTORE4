<?php
namespace app\services;

class Autoload
{
    public function load($className)
    {
        $fileName = str_replace(
            ['app\\', '\\'],
            [dirname(__DIR__) . '/', '/'],
            $className
        );
        $fileName .= '.php';
        if (file_exists($fileName)) {
            include $fileName;
        }
    }
}