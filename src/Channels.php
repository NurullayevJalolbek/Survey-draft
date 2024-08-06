<?php

declare(strict_types=1);

class Channels
{

    private  PDO $pdo;

    public function __construct()
    {
        $this->pdo = DB::connect();
    }

    public  function  allCHANNEL()
    {
        $stmt = $this ->pdo->prepare("SELECT * FROM channels");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
