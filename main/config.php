<?php

return [
    'projectName' => 'магазин одежды',
    'defaultController' => 'good',
    'components' => [
        'db' => [
            'class' => \app\services\DB::class,
            'config' => [
                'driver' => 'mysql',
                'host' => 'localhost',
                'db' => 'gbphp',
                'charset' => 'UTF8',
                'login' => 'root',
                'password' => 'root'
            ]
        ],
        'renderer' => [
            'class' => \app\services\TwigRenderServices::class
        ],
        'goodRepository' => [
            'class' => \app\repositories\GoodRepository::class
        ],
        'userRepository' => [
            'class' => \app\repositories\UserRepository::class
        ],
        'basketServices' => [
            'class' => \app\services\BasketServices::class
        ]
    ]
];