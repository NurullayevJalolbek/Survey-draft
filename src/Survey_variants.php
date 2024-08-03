<?php

class Survey_variants
{
    private  PDO $pdo;


    public function __construct()
    {
        $this->pdo = DB::connect();
    }

    public function survey_variantsAll($votes_id): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM survey_variants WHERE survey_id = :votes_id");  
        $stmt->bindParam(":votes_id", $votes_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
