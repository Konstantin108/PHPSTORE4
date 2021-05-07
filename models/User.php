<?php

namespace app\models;

/**
 * Class User
 * @package app\models
 * @method static getAll() self
 */
class User extends Model
{
    public $id = '';
    public $login = '';
    public $password = '';
    public $name = '';
    public $is_admin = '';
    public $position = '';

    protected static function getTableName(): string
    {
        return 'users';
    }
}