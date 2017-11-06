<?php

session_start();

class Database {

    private static $_instance = null;

    /**
     *
     * @var PDO 
     */
    private $pdo;

    private function __construct() {
        $dsn = "mysql:host=localhost;dbname=cms";
        $username = "root";
        $password = "";

        $this->pdo = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
    }

    /**
     * 
     * @return self
     */
    public static function instance() {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    public function getPDO() {
        return $this->pdo;
    }

    /**
     * 
     * @param strig $query
     * @return PDOStatement
     */
    public function prepare($query) {
        return $this->pdo->prepare($query);
    }

    public function fetchAssoc($query, $params = []) {
        $statement = $this->pdo->prepare($query);

        foreach ($params as $key => $param) {
            $statement->bindParam(":$key", $param);
        }

        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

}