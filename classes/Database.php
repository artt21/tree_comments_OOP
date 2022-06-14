<?php

class Database{

    private const HOST = 'localhost';
    private const USERNAME = 'root';
    private const CHARSET = 'utf8mb4';
    private string $password = '';
    private string $dbName = 'comments';
    private ?PDO $pdo = null;
    private array $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    private function connect(): PDO
    {

        if(!$this->pdo){
            $dsn = 'mysql:host=' . self::HOST . ';dbname=' . $this->dbName .';charset=' . self::CHARSET;
            $this->pdo = new PDO($dsn, self::USERNAME, $this->password, $this->options);
        }

        return $this->pdo;

    }

    public function query(string $sql, array $args = null): PDOStatement
    {

        $connect = $this->connect();

        if (!$args) {
            return $connect->query($sql);
        }

        return $connect->prepare($sql);

    }

}
