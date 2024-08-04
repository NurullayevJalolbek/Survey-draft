<?php

declare(strict_types=1);
require_once "vendor/autoload.php";

require_once "src/Users.php";
$users = new Users();

require_once "src/Survey_variants.php";
$suveyVariant = new Survey_variants();

require_once "src/Surveys.php";
$surveys = new Surveys();


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

        $users->deletDATA($chat_id);

        $user = $users->userGet($chat_id);
        if (!$user) {
            $users->usersAdd($chat_id, (string)$name = null, $phone = null);
            $bot->startCommand($chat_id);
            return;
        } else {
            $bot->sendSurveys($chat_id);
            return;
        }
    }

    if ($text == "/sorovnomalar") {
        $bot->sendSurveys($chat_id);
        return;
    }
    if (isset($message->contact)) {
        $first_name = $message->contact->first_name ?? '';
        $last_name = $message->contact->last_name ?? '';
        $name = trim("$first_name $last_name");
        $messsage_id = $message->message_id;

        $chat_Id = $message->chat->id;

        $phone = $message->contact->phone_number;


        if ($message->contact->user_id != $chat_Id) {
            $bot->kontagError($chat_Id);
            return;
        }
        $bot->removeKeyboard($chat_Id);
        $users->userUpdate((int)$chat_Id, (string)$name, (int)$phone);
        $bot->sendSurveys($chat_Id);
    }
}

if (isset($update->callback_query)) {

    $callbackQuery = $update->callback_query;
    $callbackData = $callbackQuery->data;
    $chatId = $callbackQuery->message->chat->id;
    $messageId = $callbackQuery->message->message_id;

    if (strpos($callbackData, 'tekshirish') !== false) {
        $dataID = $users->allDATA($chatId);
        $bot->channel_check($chatId, $messageId);

        // Kanalga a'zo ekanligini tekshirib, variantlarni yuborish
        $status = $bot->isMember((int)-1002170814544, (int)$chatId);
        if ($status === 'member' || $status === 'administrator' || $status === 'creator') {
            $bot->sendVariants($chatId, $messageId, (int)$dataID);
            return;
        }
    }

    $colbacdata = explode('-', $callbackData);
    $colbacdata = $colbacdata[1];

    $idArray = $surveys->surveysID();


    if (array_search($colbacdata, $idArray) != true) {
        $status = $bot->isMember((int)-1002170814544, (int)$chatId);

        $users->addDATA($chatId, $colbacdata);

        if ($status !== 'member' && $status !== 'administrator' && $status !== 'creator') {

            $bot->channel_check($chatId);
            return;
        } else {

            $bot->sendVariants($chatId, $messageId, $colbacdata);
        }
    }
}
