<?php
namespace app\models;
use app\services\DB;

abstract class Model
{
    /**
     * @return mixed
     */
    abstract protected function getTableName():string;

    /**
     * @return DB
     */
    protected function getDB()
    {
        return DB::getInstance();
    }

    public function getOne($id)
    {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName} where id = :id";
        $params = [
            ':id'=> $id
        ];
        return $this->getDB()->find($sql, $params);
    }

    public function getAll()
    {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName}";
        return $this->getDB()->findAll($sql);
    }

    public function insert()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }
}