<?php

declare(strict_types=1);
require_once "vendor/autoload.php";

require_once "src/Users.php";
$users = new Users();

require_once "src/Survey_variants.php";
$suveyVariant = new Survey_variants();

require_once "src/Surveys.php";
$surveys = new Surveys();

require_once "src/Votes.php";
$votes = new Votes();

require_once "src/Channels.php";
$channels = new Channels();


require_once "src/Bot.php";
$bot = new Bot($_ENV['BOT_TOKEN']);
$update = json_decode(file_get_contents('php://input'));

if (isset($update->message)) {
    $message = $update->message;
    $text = $message->text ?? '';
    $chat_id = $message->chat->id;

    $message_id = $message->message_id;


    if ($text == "/start") {

        $users->deletDATA($chat_id);

        $user = $users->userGet($chat_id);

        if (!$user) {
            $users->usersAdd($chat_id, (string)$name = null, $phone = null);
            $bot->startCommand($chat_id);
            return;
        } else {
            if (!$user['phone_number']) {
                {
                    $bot->startCommand($chat_id);
                    return;
                }
            }
            $bot->sendSurveys($chat_id);
            return;
        }
    }
    if (strpos($text, '/start') === 0) {

        $channelARREY = $channels->allCHANNEL();

        $survey_votes = str_replace('/start ', '', $text);

        $user = $users->userGet($chat_id);
        if (!$user) {
            $users->usersAdd($chat_id, (string)$name = null, $phone = null);
        }

        $status1 = $bot->isMember2($channelARREY, (int)$chat_id);
        echo $status1;
        if ($status1  === false) {

            $bot->channel_check2((int)$chat_id, (array)$channelARREY);
            $users->usersUpdatedata($chat_id, (string)$survey_votes, (string)$name = null, $phone = null);
            return;
        }


        $uservariantID = $survey_votes;

        $survey_id = $suveyVariant->survey_idALL($uservariantID);
        $survey_id = $survey_id['survey_id'];

        $userID = $users->userID($chat_id);
        $userID = $userID['id'];

        $arrayVotes = $votes->allVOTES((int )$userID, (int)$survey_id);
        if ($arrayVotes !== true) {
            $votes->addVOTES((int)$userID, (int)$survey_id, (int)$uservariantID);
            $bot->votes2($chat_id);
            return;
        }
        $bot->votesERROR2($chat_id);
        return;

    }


    if ($text == "/sorovnomalar") {
        $user = $users->userGet($chat_id);

        if (!$user) {
            $users->usersAdd($chat_id, (string)$name = null, $phone = null);
            $bot->startCommand($chat_id);
            return;
        } else {
            if (!$user['phone_number']) {
                $bot->startCommand($chat_id);
                return;
            }
            $bot->sendSurveys($chat_id);
            return;
        }
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


    $channelARREY = $channels->allCHANNEL();
    $dataID = $users->allDATA($chatId);


    if (strpos($callbackData, 'tekshirish') !== false) {


        $bot->channel_check($chatId, $channelARREY);


        $status = $bot->isMember($channelARREY, (int)$chatId);


        if ($status) {
            $bot->sendVariants($chatId, $messageId, (int)$dataID);
            return;
        }
    }


    if (strpos($callbackData, 'TEKSHIRISH') !== false) {


        $status = $bot->isMember2($channelARREY, (int)$chatId);


        if ($status) {
            $uservariantID = $users->allDATA($chatId);
            $uservariantID = $uservariantID['data'];

            $survey_id = $suveyVariant->survey_idALL($uservariantID);
            $survey_id = $survey_id['survey_id'];

            $userID = $users->userID($chatId);
            $userID = $userID['id'];

            $arrayVotes = $votes->allVOTES((int )$userID, (int)$survey_id);
            if ($arrayVotes !== true) {
                $votes->addVOTES((int)$userID, (int)$survey_id, (int)$uservariantID);
                $bot->votes2($chatId);
                return;
            }
            $bot->votesERROR2($chatId);
            return;


        }
        $bot->channel_check2((int)$chatId, (array)$channelARREY);




    }

    if (strpos($callbackData, 'id-') !== false) {

        $colbacdata = explode('-', $callbackData);
        $colbacdata = $colbacdata[1];


        $idArray = $surveys->surveysID($colbacdata);


        if ($idArray) {


            $channelARREY = $channels->allCHANNEL();


            $status = $bot->isMember($channelARREY, (int)$chatId);

            $users->addDATA($chatId, $colbacdata);

            if (!$status) {
                $bot->channel_check((int)$chatId, (array)$channelARREY);
                return;
            } else {
                $bot->sendVariants($chatId, $messageId, $colbacdata);
            }
        }
    }


    if (strpos($callbackData, 'page-') === 0) {

        $page = (int)substr($callbackData, 5);
        $bot->sendSurveys2($chatId, $messageId, $page);
        return;
    }
    if (strpos($callbackData, 'page_') === 0) {

        $page = (int)substr($callbackData, 5);
        $dataID = $users->allDATA($chatId);

        $bot->sendVariants($chatId, $messageId, (int )$dataID, $page);
        return;
    }

    if (strpos($callbackData, 'id_') !== false) {

        $colbacdata = explode('_', $callbackData);
        $colbacdata = $colbacdata[1];

        $userdata = $users->allDATA($chatId);

        $userID = $users->userID($chatId);
        $userID = $userID['id'];

        $arrayVotes = $votes->allVOTES((int )$userID, (int)$userdata['data']);

        if ($arrayVotes !== true) {
            $votes->addVOTES($userID, (int)$userdata['data'], (int)$colbacdata);
            $bot->votes($chatId, $messageId);
            $bot->sendLINK($chatId, $colbacdata);

            $survey_votes = "{$userdata['data']}_$colbacdata";
            $users->addsurvey_votes($chatId, $survey_votes);
            return;
        }
        $bot->votesERROR($chatId, $messageId);
        return;


    }
}
