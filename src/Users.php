<?php
declare (strict_types=1);
require_once "src/DB.php";

class Users
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = DB::connect();
    }
    public function usersAdd(int $chat_id, $name , $phone): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (user_id, created_at, name, phone_number) VALUES (:chat_id, NOW(), :name, :phone)");
        $stmt ->bindParam(":chat_id", $chat_id, PDO::PARAM_INT);
        $stmt ->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt -> bindParam(":phone", $phone, PDO::PARAM_INT);
        $stmt -> execute();

    }
    public function userAll(): array
    {
        $stmt = $this->pdo->prepare("SELECT user_id FROM users");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function userGet(int $chat_id): array|bool{
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE user_id = $chat_id");
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
    
    
}