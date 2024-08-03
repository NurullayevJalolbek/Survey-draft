<?php

declare(strict_types=1);
require_once "vendor/autoload.php";

require_once "src/Users.php";
$users = new Users();

require_once "src/Survey_variants.php";
$suveyVariant = new Survey_variants();


require_once "src/Bot.php";
$bot = new Bot($_ENV['BOT_TOKEN']);
$update = json_decode(file_get_contents('php://input'));

if (isset($update->message)) {
    $message = $update->message;
    $text = $message->text ?? '';
    $chat_id = $message->chat->id;
    $message_id = $message->message_id;

    $malumotlar = $users->userAll();

    if ($text == "/start") {
        $user = $users->userGet($chat_id);
        if (!$user) {
            $users->usersAdd($chat_id, (string)$name = null, (int)$phone = null);
            $bot->startCommand($chat_id, $message_id);

            return;
        }
        $bot->sendSurveys($chat_id,$message_id);
    }
    if (isset($message->contact)) {
        $first_name = $message->contact->first_name ?? '';
        $last_name = $message->contact->last_name ?? '';
        $name = trim("$first_name $last_name");

        $chat_Id = $message->chat->id;

        $phone = $message->contact->phone_number;

        $users->userUpdate((int)$chat_Id, (string)$name, (int)$phone);

        if ($message->contact->user_id != $chat_Id) {
            $bot->kontagError($chat_Id,$message_id);
            return;
        }
        $bot->sendSurveys($chat_Id, $message_id);
    }
}

if (isset($update->callback_query)) {

    $callbackQuery = $update->callback_query;
    $callbackData = $callbackQuery->data;
    $chatId = $callbackQuery->message->chat->id;
    $messageId = $callbackQuery->message->message_id;

    $colbacdata = explode('-', $callbackData);
    $colbacdata = $colbacdata[1];
    $bot->sendVariants($chatId, $message_id, $colbacdata);
}
