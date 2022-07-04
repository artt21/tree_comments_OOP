<?php

class Database{

    private const HOST = 'localhost';
    private const USERNAME = 'root';
    private const CHARSET = 'utf8mb4';
    private const PASSWORD = '';
    private const DBNAME = 'comments';
    private const OPTIONS = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];
    private ?PDO $pdo = null;

    private function connect(): void
    {

        if(!$this->pdo){
            $dsn = 'mysql:host=' . self::HOST . ';dbname=' . self::DBNAME .';charset=' . self::CHARSET;
            $this->pdo = new PDO($dsn, self::USERNAME, self::PASSWORD, self::OPTIONS);
        }

    }

    public function query(string $sql, array $args = []): PDOStatement
    {

        $this->connect();

        if (!$args) {
            return $this->pdo->query($sql);
        }

        return $this->pdo->prepare($sql);

    }

}
