<?php

namespace app\controllers;

use app\entities\Good;
use app\repositories\GoodRepository;

class GoodController extends Controller
{

    public function allAction()
    {
        $goods = (new GoodRepository())->getAll();

        return $this->renderer->render(
            'goodAll',
            [
                'goods' => $goods
            ]);
    }

    public function oneAction()
    {
        $id = $this->getId();
        $good = (new GoodRepository())->getOne($id);
        return $this->renderer->render(
            'goodOne',
            [
                'good' => $good
            ]);
    }

    public function editAction()
    {
        $id = $this->getId();
        $good = (new GoodRepository())->getOne($id);
        if ($_SERVER['REQUEST_METHOD'] = 'POST') {
            return $this->renderer->render(
                'goodEdit',
                [
                    'good' => $good
                ]);
        }
    }

    public function updateAction()
    {
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

        if (!empty($name) &&
            !empty($price) &&
            !empty($info)
        ) {
            (new GoodRepository())->save($good);
            header('Location: /good/all');
            return '';
        } else {
            return $this->renderer->render(
                'emptyFields',
                [
                    'good' => $good
                ]);
        }
    }

    public function delAction()
    {
        $id = $this->getId();
        $good = (new GoodRepository())->getOne($id);
        if ($_SERVER['REQUEST_METHOD'] = 'POST') {
            return $this->renderer->render(
                'goodDel',
                [
                    'good' => $good
                ]);
        }
    }

    public function getDelAction()
    {
        $id = $this->getId();
        $good = new Good();
        $good->id = $id;
        (new GoodRepository())->delete($good);
        header('Location: /good/all');
        return '';
    }
}