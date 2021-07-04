<?php


namespace app\repositories;

use app\entities\Good;
use app\repositories\Repository;

class GoodRepository extends Repository
{

    protected function getTableName(): string
    {
        return 'goods';
    }

    protected function getEntityName(): string
    {
        return Good::class;
    }
}