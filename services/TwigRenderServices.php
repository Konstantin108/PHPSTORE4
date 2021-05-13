<?php


namespace app\services;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigRenderServices implements RenderI
{
    protected $twig;

    /**
     * TwigRenderServices constructor.
     * @param $twig
     */
    public function __construct()
    {
        $loader = new FilesystemLoader([
            dirname(__DIR__) . '/views/layouts',
            dirname(__DIR__) . '/views'
        ]);
        $this->twig = new Environment($loader);
    }

    /**
     * @param $template
     * @param array $params
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function render($template, $params = [])
    {
        $template .= '.twig';
        return $this->twig->render($template, $params);
    }
}