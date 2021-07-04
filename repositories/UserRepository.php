<?php


namespace app\repositories;

use app\entities\User;
use app\repositories\Repository;

class UserRepository extends Repository
{

    protected function getTableName(): string
    {
        return 'users';
    }

    protected function getEntityName(): string
    {
        return User::class;
    }
}