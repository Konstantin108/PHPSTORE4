<?php


namespace app\services;


interface RenderI
{
    public function render($template, $params = []);
}