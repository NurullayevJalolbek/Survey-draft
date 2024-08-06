<?php
declare (strict_types=1);
require_once "src/DB.php";
class Votes
{

    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = DB::connect();
    }


    public function addVOTES(int $user_id, int $survey_id, int $survey_variant_id): void
    {

        $stmt = $this->pdo->prepare("INSERT INTO votes (user_id, survey_id, survey_variant_id) VALUES (:user_id, :survey_id, :survey_variant_id)");
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":survey_id", $survey_id,);
        $stmt->bindParam(":survey_variant_id", $survey_variant_id,);
        $stmt->execute();
    }
    public function allVOTES(): array
    {

        $stmt = $this->pdo->prepare("SELECT * FROM votes");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



}
