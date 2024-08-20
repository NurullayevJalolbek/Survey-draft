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
        echo $votes_id;
        $stmt = $this->pdo->prepare("SELECT * FROM survey_variants WHERE survey_id = :votes_id");  
        $stmt->bindParam(":votes_id", $votes_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public  function  survey_idALL( $survey_variant_id)
    {

        $stmt = $this->pdo->prepare("SELECT survey_id FROM survey_variants WHERE id = :survey_variant_id");
        $stmt->bindParam(":survey_variant_id", $survey_variant_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);

    }

    public  function  surveyId( $survey_variant_id)
    {

        $stmt = $this->pdo->prepare("SELECT survey_id FROM survey_variants WHERE id = :survey_variant_id");
        $stmt->bindParam(":survey_variant_id", $survey_variant_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);

    }
}
