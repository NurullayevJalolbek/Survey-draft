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
//    web part
    public function getUsersInfo (): false|array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM admin");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function addNewAdmin (string $username, string $password, int $userId): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO admin (username, password, userId) VALUES (:username, :password, :userId)");
        $stmt->bindParam(":username", $username);
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bindParam(":password", $hash);
        $stmt->bindParam(":userId", $userId);
        $stmt->execute();

        header('location: /admin');
    }
    public function getSurveys (): false|array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM surveys");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function addSurveys(string $name, string $description, string $expired)
    {
        $stmt = $this->pdo->prepare("INSERT INTO `surveys` (`name`, `desc`, `expired_at`) VALUES (:name, :description, :expired)");
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":expired", $expired);
        $stmt->execute();

        header('location: /home');
        exit();
    }
    public function  getSurveyInsert (int $id): false|array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM survey_variants WHERE survey_id = :survey_id");
        $stmt->bindParam(":survey_id", $id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getSurveyName (int $id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM surveys WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function addSurveryVariants (string $name, int $id)
    {
        $stmt = $this->pdo->prepare("INSERT INTO survey_variants (survey_id, name) VALUES (:survey_id, :name)");
        $stmt->bindParam(":survey_id", $id);
        $stmt->bindParam(":name", $name);
        $stmt->execute();

        header('location: /insert?id=' . $_SESSION['id']);
        exit();
    }
    public function getChannelsId (): false|array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM channels");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function addChannelsId (string $channelId)
    {
        $stmt = $this->pdo->prepare("INSERT INTO channels (channel_id) VALUES (:channel_id)");
        $stmt->bindParam(":channel_id", $channelId);
        $stmt->execute();

        header('location: /channels');
        exit();
    }
}