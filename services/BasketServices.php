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
                'price' => $good->price,
                'id' => $good->id
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

    public function plus($userId, $id, GoodRepository $goodRepository)
    {
        /**
         * @var Good $good
         */
        $good = $goodRepository->getOne($id);
        $_SESSION['goods'][$userId][$id]['counter']++;
        $count = $_SESSION['goods'][$userId][$id]['counter'];
        $price = $good->price;
        $newPrice = $count * $price;
        $_SESSION['goods'][$userId][$id]['price'] = $newPrice;
        return '';
    }

    public function minus($userId, $id, GoodRepository $goodRepository)
    {
        /**
         * @var Good $good
         */
        $good = $goodRepository->getOne($id);
        $count = $_SESSION['goods'][$userId][$id]['counter'];
        if ($count > 1) {
            $_SESSION['goods'][$userId][$id]['counter']--;
            $newCount = $_SESSION['goods'][$userId][$id]['counter'];
            $price = $good->price;
            $newPrice = $newCount * $price;
            $_SESSION['goods'][$userId][$id]['price'] = $newPrice;
        } else {
            unset($_SESSION['goods'][$userId][$id]);
        }
        return '';
    }

    public function del($userId, $id)
    {
        unset($_SESSION['goods'][$userId][$id]);
        return '';
    }
}