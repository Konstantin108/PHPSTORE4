<?php

namespace app\services;

use app\entities\Good;
use app\repositories\GoodRepository;

class BasketServices
{
    const BASKET_NAME = 'goods';

    public function add($userId, $id, GoodRepository $goodRepository)
    {
        if (empty($id)) {
            return 'нет id';
        }
        /**
         * @var Good $good
         */
        $good = $goodRepository->getOne($id);
        if (empty($id)) {
            return 'нет товара';
        }
        if (empty($_SESSION[self::BASKET_NAME][$userId][$id])) {
            $_SESSION[self::BASKET_NAME][$userId][$id] = [
                'img' => $good->img,
                'name' => $good->name,
                'counter' => $good->counter,
                'price' => $good->price
            ];
            return 'товар добавлен';
        }
        $count = $_SESSION[self::BASKET_NAME][$userId][$id]['counter'];
        $count++;
        $price = $good->price * $count;
        $_SESSION[self::BASKET_NAME][$userId][$id]['counter'] = $count;
        $_SESSION[self::BASKET_NAME][$userId][$id]['price'] = $price;
        return 'количество увеличено';
    }
}