<?php 

declare (strict_types=1);
require_once "src/DB.php";

class Surveys
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = DB::connect();
    }

    public function surveysAll(): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM surveys");
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function surveysID(): array
    {
        $stmt = $this->pdo->prepare("SELECT id FROM surveys ");
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}