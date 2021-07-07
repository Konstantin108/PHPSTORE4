<?php

namespace app\services;

use app\entities\Good;
use app\repositories\GoodRepository;

class BasketServices
{
    const BASKET_NAME = 'goods';

    public function add($id, GoodRepository $goodRepository, Request $request)
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

        $goods = $request->getSession(self::BASKET_NAME);

        if (empty($goods[$id])) {
            $goods[$id] = [
                'name' => $good->name,
                'counter' => $good->counter,
                'price' => $good->price
            ];
            $request->setSession(self::BASKET_NAME, $goods);
            return 'товар добавлен';
        }
        $goods[$id]['counter']++;
        $request->setSession(self::BASKET_NAME, $goods);
        return 'количество увеличено';
    }
}