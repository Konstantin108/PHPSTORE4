<?php

namespace app\entities;

/**
 * Class User
 * @package app\entities
 */
class User extends Entity
{
    public $id = '';
    public $login = '';
    public $password = '';
    public $name = '';
    public $is_admin = '';
    public $position = '';
}