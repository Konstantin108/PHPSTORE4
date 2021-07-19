<?php

namespace app\repositories;

use app\entities\Entity;
use app\main\Container;
use app\services\DB;

/**
 * Class Repository
 * @package app\repositories
 */
abstract class Repository
{
    /**
     * @var Container
     */
    protected $container;

    abstract protected function getTableName(): string;

    abstract protected function getEntityName(): string;

    public function setContainer(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @return DB
     */
    protected function getDB()
    {
        return $this->container->db;
    }

    public function getOne($id)
    {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName} where id = :id";
        $params = [
            ':id' => $id
        ];
        return $this->getDB()->getObject($sql, $this->getEntityName(), $params);
    }

    /**
     * @return array
     */
    public function getAll()
    {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName}";
        return $this->getDB()->getAllObjects($sql, $this->getEntityName());
    }

    /**
     * @param Entity $entity
     * @return Entity
     */
    protected function insert(Entity $entity)
    {
        $fields = [];
        $params = [];
        foreach ($entity as $fieldName => $value) {      //<-- Получение всех столбцов из таблицы
            if ($fieldName == 'id') {
                continue;
            }
            $fields[] = $fieldName;
            $params[":{$fieldName}"] = $value;
        }

        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",      //<-- Заполнение всех столбцов из таблицы
            $this->getTableName(),
            implode(',', $fields),
            implode(',', array_keys($params))
        );
        $this->getDB()->execute($sql, $params);
        $entity->id = $this->getDB()->getLastId();
        return $entity;
    }

    /**
     * @param Entity $entity
     */
    protected function update(Entity $entity)
    {
        $fields = [];
        $params = [];
        foreach ($entity as $fieldName => $value) {
//            if ($fieldName == 'password') {
//                continue;
//            }
            $fields[] = $fieldName;
            $params[":{$fieldName}"] = $value;
        }

        foreach ($fields as $value) {
            $fixFields[] = $value . ' = :' . $value;
        }
        $shiftFields = array_shift($fixFields);
        $string = implode(', ', $fixFields);

        $sql = sprintf(
            "UPDATE %s SET %s WHERE %s",      //<-- Заполнение всех столбцов из таблицы
            $this->getTableName(),
            $string,
            $shiftFields
        );
        $this->getDB()->execute($sql, $params);
        return $entity;
    }

    /**
     * @param Entity $entity
     */
    public function save(Entity $entity)
    {
        if (empty($entity->id)) {
            return $this->insert($entity);
        }
        return $this->update($entity);
    }

    /**
     * @param Entity $entity
     */
    public function delete(Entity $entity)
    {
        $sql = sprintf(
            "DELETE FROM %s WHERE id = %s",
            $this->getTableName(),
            $entity->id
        );
        $this->getDB()->execute($sql);
    }
}