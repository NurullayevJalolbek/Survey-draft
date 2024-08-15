<?php
declare (strict_types=1);
class DB
{
    protected  PDO $pdo;
    public  function  __construct()
    {
        $this->pdo = DB::connect();

    }
    public static function connect(): PDO
    {
        $dsn = "{$_ENV['DB_CONNECTION']}:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']}";
        return new PDO($dsn, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
    }
}


