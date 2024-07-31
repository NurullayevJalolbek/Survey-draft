<?php

declare(strict_types=1);
require_once "vendor/autoload.php";

require_once "src/Users.php";
$users = new Users();

require_once "src/Bot.php";
$bot = new Bot($_ENV['BOT_TOKEN']);
$update = json_decode(file_get_contents('php://input'));

if (isset($update->message)) {
    $message = $update->message;
    $text = $message->text ?? '';
    $chat_id = $message->chat->id;

    $malumotlar = $users->userAll();

    $user_found = false;

    if ($text === "/start") {
        $user = $users->userGet($chat_id);
        if (!$user) {
            $users->usersAdd($chat_id, (string)$name = null, (int)$phone = null);
            $bot->startCommand($chat_id);
            return;
        }
        $bot->inLine($chat_id, "Botdan foydalanish uchun quyidagi tugmani bosing");
    }
    if (isset($message->contact)) {
        $first_name = $message->contact->first_name ?? '';
        $last_name = $message->contact->last_name ?? '';
        $name = trim("$first_name $last_name");

        $chat_Id = $message->chat->id;

        $phone = $message->contact->phone_number;

        $users->userUpdate((int)$chat_Id, (string)$name, (int)$phone);

        if ($message -> contact -> user_id != $chat_Id){
            $bot -> sendMessage($chat_id);
            return;
        }

        
    }
}
