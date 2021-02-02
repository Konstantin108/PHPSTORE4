<?php
namespace app\models;

class Good extends Model
{
    protected function getTableName():string
    {
        return 'goods';
    }
}