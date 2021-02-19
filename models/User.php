<?php
namespace app\models;

class User extends Model
{
    public $id = '';
    public $login = '';
    public $password = '';
    public $name = '';
    public $is_admin = '';
    public $position = '';

    protected static function getTableName():string
    {
        return 'users';
    }
}