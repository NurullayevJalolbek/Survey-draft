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
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->bindParam(":survey_id", $survey_id, PDO::PARAM_INT);
        $stmt->bindParam(":survey_variant_id", $survey_variant_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function allVOTES(int $user_Id, int $userdATA): bool
    {
        $stmt = $this->pdo->prepare("SELECT survey_id, user_id FROM votes WHERE user_id = :user_Id AND survey_id = :userdATA");
        $stmt->bindParam(":user_Id", $user_Id, PDO::PARAM_INT);
        $stmt->bindParam(":userdATA", $userdATA, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result !== false;

    }
}
