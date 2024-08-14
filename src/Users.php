<?php

declare(strict_types=1);
require_once "src/DB.php";

class Users
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = DB::connect();
    }
    public function usersAdd(int $chat_id,  $name, $phone): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (user_id, created_at, name, phone_number) VALUES (:chat_id, NOW(), :name, :phone)");
        $stmt->bindParam(":chat_id", $chat_id, PDO::PARAM_INT);
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":phone", $phone);
        $stmt->execute();
    }
    public function usersUpdatedata(int $chat_id, $userData, $name, $phone): void
    {
        $stmt = $this->pdo->prepare(" UPDATE users SET data = :userData, name = :name, phone_number = :phone  WHERE user_id = :chat_id ");

        $stmt->bindParam(":chat_id", $chat_id, PDO::PARAM_INT);
        $stmt->bindParam(":userData", $userData, PDO::PARAM_STR);
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":phone", $phone, PDO::PARAM_STR);

        $stmt->execute();
    }


    public  function  allchatID(int $token):bool
    {
        $stmt = $this->pdo->prepare("SELECT user_id FROM users WHERE user_id = :token");
        $stmt->bindParam(":token", $token, PDO::PARAM_INT);
        $stmt->execute();
        $resul = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resul !== false;

    }

    public  function  addsurvey_votes($chat_id, string $survey_votes)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET survey_votes = :survey_votes WHERE user_id = :chat_id");
        $stmt->bindParam(":chat_id", $chat_id, PDO::PARAM_INT);
        $stmt->bindParam(":survey_votes", $survey_votes, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function userGet(int $chat_id): array|bool
    {
        // SQL so'rovda parametrni foydalaning
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE user_id = :chat_id");
        $stmt->bindParam(":chat_id", $chat_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }





    public function userUpdate(int $chat_id, string $name, int $phone)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET name = :name, phone_number = :phone WHERE user_id = :chat_id");
        $stmt->bindParam(":chat_id", $chat_id, PDO::PARAM_INT);
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":phone", $phone, PDO::PARAM_INT);
        $stmt->execute();
    }


    public function addDATA(int $chat_id, string|null $data): void
    {
        $stmt = $this->pdo->prepare("UPDATE users SET data = :data WHERE user_id = :chat_id");
        $stmt->bindParam(":chat_id", $chat_id, PDO::PARAM_INT);
        $stmt->bindParam(":data", $data, PDO::PARAM_STR);
        $stmt->execute();
    }

    public  function  userID($chat_id)
    {
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE user_id = :chat_id");
        $stmt->bindParam(":chat_id", $chat_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);

    }



    public function deletDATA(int $chat_id): void
    {
        $stmt = $this->pdo->prepare("UPDATE users SET data = NULL WHERE user_id = :chat_id");
        $stmt->bindParam(":chat_id", $chat_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function allDATA($chat_id)
    {
        $stmt = $this->pdo->prepare("SELECT data FROM users WHERE user_id = :chat_id");
        $stmt->bindParam(":chat_id", $chat_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
