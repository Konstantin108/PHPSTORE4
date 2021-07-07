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
                'name' => $good->name,
                'counter' => $good->counter,
                'price' => $good->price
            ];
            return 'товар добавлен';
        }
        $_SESSION[self::BASKET_NAME][$userId][$id]['counter']++;
        return 'количество увеличено';
    }
}