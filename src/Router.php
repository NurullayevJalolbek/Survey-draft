<?php

declare(strict_types=1);

use GuzzleHttp\Exception\GuzzleException;
use JetBrains\PhpStorm\NoReturn;

class Router extends DB
{
    #[NoReturn] public function login(string $username, string $password): void
    {
        $stmt = $this->pdo->prepare("SELECT * FROM admin WHERE username = :username");
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        $result = $stmt->fetch();

        if ($result && password_verify($password, $result['password']) && $result['username'] === $username) {
            $_SESSION['username'] = $username;
            unset($_SESSION['error']);
            header('Location: /admin');
        } else {
            $_SESSION['error'] = "Password or username is incorrect";
            header('Location: /login');
        }
        exit();
    }
    #[NoReturn] public function checkAvailability(): void
    {
        if (!isset($_SESSION['username'])) {
            $_SESSION['check'] = 1;
            header('Location: /login');
            exit();
        }
    }
    #[NoReturn] public function logout(): void
    {
        session_destroy();

        header('Location: /login');
        exit();
    }
    public function get(string $path, $callback): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) === $path) {
            $callback();
            exit();
        }
    }

    public function post(string $path, $callback): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) === $path) {
            $callback();
            exit();
        }
    }

    #[NoReturn] public function delete(int $id, string $table, string $dynamicHeader = NULL): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM $table WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        header("location: /{$dynamicHeader}");
        exit();
    }

    #[NoReturn] public function edit(int $id, string $table, string $name, string $dynamicHeader): void
    {
        $stmt = $this->pdo->prepare("UPDATE $table SET name = :name WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":name", $name);
        $stmt->execute();

        header("location: /{$dynamicHeader}");
        exit();
    }

    #[NoReturn] public function notFount(): void
    {
        http_response_code(response_code: 404);
        require 'pages/partials/errors.php';
        exit();
    }

    public function checkUserId(int $chatId): bool
    {
        $stmt = $this->pdo->prepare("SELECT userId FROM admin WHERE userId = :chatId");
        $stmt->bindParam(":chatId", $chatId);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result !== false;
    }

    public function saveAds(int $chatId, int $messageId): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO ads (chatId, messageId) VALUES (:chatID, :messageId)");
        $stmt->bindParam(":chatID", $chatId);
        $stmt->bindParam(":messageId", $messageId);
        $stmt->execute();
    }

    public function saveStatus(string $status, int $userId): void
    {
        $stmt = $this->pdo->prepare("UPDATE admin SET status = :status WHERE userId = :user_id");
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":user_id", $userId);
        $stmt->execute();
    }

    public function getStatus(string $status, int $chat_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM admin WHERE status = :status and userId=:user_id");
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":user_id", $chat_id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) ?? false;
    }

    public function deleteStatus(int $userId): void
    {
        $stmt = $this->pdo->prepare("UPDATE admin SET status = null WHERE userId = :user_id");
        $stmt->bindParam(":user_id", $userId);
        $stmt->execute();
    }

    /**
     * @throws GuzzleException
     */
    public function sendUserAds(): void
    {
        $stmt = $this->pdo->query("SELECT * FROM ads");
        $ads = $stmt->fetchAll(PDO::FETCH_ASSOC);

//        $stmt = $this->pdo->query("SELECT * FROM user LIMIT 5 OFFSET 0");


        $stmt = $this->pdo->query("SELECT user_id FROM user");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);


        foreach ($users as $user) {
            $userId = $user["user_id"];

            foreach ($ads as $ad) {
                (new BotSendMessage())->sendAllMessageAds((int)$userId, $ad);
            }
        }
    }

    public function checkCron(): false|int
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '';
        $path = parse_url($uri, PHP_URL_PATH);

        return array_search("cron", explode('/', $path));
    }

    public function UserId(int $userId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM user WHERE user_id = :user_id");
        $stmt->bindParam(":user_id", $userId);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result !== false ? $result['user_id'] : false;
    }

    public function saveUserId($userId): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO user (user_id) VALUES (:user_id)");
        $stmt->bindParam(":user_id", $userId);
        $stmt->execute();
    }

    public function deleteAds(): void
    {
        $stmt = $this->pdo->query("TRUNCATE TABLE ads");
    }
}