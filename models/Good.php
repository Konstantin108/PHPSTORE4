<?php
namespace app\models;

class Good extends Model
{
    public $id = '';
    public $name = '';
    public $price = '';
    public $info = '';
    public $counter = '';

    protected static function getTableName():string
    {
        return 'goods';
    }
}