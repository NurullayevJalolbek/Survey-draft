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

    public function surveysID($survey_id): array
    {

        $stmt = $this->pdo->prepare("SELECT * FROM surveys where id = :survey_id ");
        $stmt->bindParam(":survey_id", $survey_id, PDO::PARAM_INT);
        $stmt->execute();

        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}