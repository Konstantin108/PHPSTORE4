<?php

namespace app\controllers;

use app\models\Good;

class GoodController
{
    public function run($action)
    {
        $action .= "Action";

        if (!method_exists($this, $action)) {
            return '404';
        }
        return $this->$action();
    }

    public function allAction()
    {
        $goods = Good::getAll();
        return $this->render('goodAll', ['goods' => $goods]);
    }

    public function oneAction()
    {
        $id = $this->getId();
        $good = Good::getOne($id);
        return $this->render('goodOne', ['good' => $good]);
    }

    public function editAction()
    {
        $id = $this->getId();
        $good = Good::getOne($id);
        return $this->render('goodEdit', ['good' => $good]);
    }

    public function updateAction()
    {
        /** @var Good $good */
        $id = $_POST['id'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $info = $_POST['info'];
        $counter = 1;

        $good = new Good();
        $good->id = $id;
        $good->name = $name;
        $good->price = $price;
        $good->info = $info;
        $good->counter = $counter;

        if(!empty($name) &&
            !empty($price) &&
            !empty($info)
        ){
            $good->save();
            header('Location: /?c=good&a=all');
            return '';
        }else{
            return $this->render('emptyFields', ['good' => $good]);
        }
    }

    public function delAction()
    {
        $id = $this->getId();
        $good = Good::getOne($id);
        return $this->render('goodDel', ['good' => $good]);
    }

    public function getDelAction()
    {
        $id = $this->getId();
        $good = Good::getOne($id);
        $good->delete();
        header('Location: /?c=good&a=all');
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