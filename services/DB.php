<?php

namespace app\services;

class DB
{
    private $config;

    private $connection;

    /**
     * DB constructor.
     * @param $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    private function getConnection()
    {
        if (empty($this->connection)) {
            $this->connection = new \PDO(
                $this->getSdn(),
                $this->config['login'],
                $this->config['password']
            );
            $this->connection->setAttribute(
                \PDO::ATTR_DEFAULT_FETCH_MODE,
                \PDO::FETCH_ASSOC
            );
        }
        return $this->connection;
    }

    private function getSdn()
    {
        return sprintf(
            "%s:host=%s;dbname=%s;charset=%s",
            $this->config['driver'],
            $this->config['host'],
            $this->config['db'],
            $this->config['charset']
        );
    }

    private function query($sql, $params = [])
    {
        $PDOStatement = $this->getConnection()->prepare($sql);
        $PDOStatement->execute($params);
        return $PDOStatement;
    }

//    public function find($sql, $params = [])     //<-- заменён на getObject()
//    {
//        return $this->query($sql, $params)->fetch();
//    }
//
//    public function findAll($sql, $params = [])     //<-- заменён на getAllObjects()
//    {
//        return $this->query($sql, $params)->fetchAll();
//    }

    public function getObject($sql, $className, $params = [])
    {
        $PDOStatement = $this->query($sql, $params);
        $PDOStatement->setFetchMode(\PDO::FETCH_CLASS, $className);
        return $PDOStatement->fetch();
    }

    public function getAllObjects($sql, $className, $params = [])
    {
        $PDOStatement = $this->query($sql, $params);
        $PDOStatement->setFetchMode(\PDO::FETCH_CLASS, $className);
        return $PDOStatement->fetchAll();
    }


    public function execute($sql, $params = [])
    {
        $this->query($sql, $params);
    }

    public function getLastId()
    {
        return $this->getConnection()->LastInsertId();
    }

    public function getLink()
    {
        static $link;
        if (empty($link)) {
            $link = mysqli_connect('127.0.0.1', 'root', 'root', 'gbphp');
        }
        return $link;
    }
}