<?php

declare(strict_types=1);

use GuzzleHttp\Exception\GuzzleException;

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
require_once "src/Router.php";

$channels = new Channels();


require_once "src/Bot.php";
$bot = new Bot($_ENV['BOT_TOKEN']);

$admin = new Router();

$update = json_decode(file_get_contents('php://input'));

if (isset($update->message)) {
    $message = $update->message;
    $text = $message->text ?? '';
    $chat_id = $message->chat->id;

    $message_id = $message->message_id;

    //admin part
    if ($text === '/admin') {
        $admin->deleteStatus($chat_id);
        if ($admin->checkUserId($chat_id)) {
            try {
                $bot->sendMessage((int)$chat_id, "Admin panel bo'limiga xush kelibsiz");
            } catch (GuzzleException $e) {
                throw new \mysql_xdevapi\Exception('test');
            }
        }
        return;
    }
    if ($text === '/ads') {
        $admin->deleteStatus($chat_id);
        if ($admin->checkUserId($chat_id)) {
            $admin->saveStatus("ads", $chat_id);
            try {
                $bot->sendMessage((int)$chat_id, "Reklama uchun kerakli ma'lumotni kiriting:");
            } catch (GuzzleException $e) {
            }
        }
        return;
    }
    if ($admin->getStatus('ads', $chat_id)) {
        try {
            $admin->saveAds($chat_id, $message_id);
            $bot->sendMessage($chat_id, 'Reklama muvoffaqayatli saqlandi');
        } catch (GuzzleException $e) {
        }
    }
    // user part
    if ($text === "/start") {

        $users->deletDATA($chat_id);

        $user = $users->userGet($chat_id);

        if (!$user) {
            $users->usersAdd($chat_id, (string)$name = null, $phone = null);
            $bot->Captcha($chat_id);
            return;
        } else {
            if (!$user['phone_number']) {
                $bot->Captcha($chat_id);
                return;
            }
            $bot->sendSurveys($chat_id);
            return;
        }

    }
    if ($text === '/statistics') {

        $user = $users->userGet($chat_id);

        if (!$user) {
            $users->usersAdd($chat_id, (string)$name = null, $phone = null);
            $bot->Captcha($chat_id);
            return;
        } else {
            if (!$user['phone_number']) {
                $bot->Captcha($chat_id);
                return;
            }
            $bot -> deletmessage($chat_id, $message_id);
            $bot->Statictics($chat_id);
            return;
        }
    }

    if (strpos($text, '/start') === 0) {

        $channelARREY = $channels->allCHANNEL();

        $survey_votes = str_replace('/start ', '', $text);


        $user = $users->userGet($chat_id);

        if (!$user) {
            $users->usersAdd($chat_id, (string)$name = null, $phone = null, (string)$survey_votes, "true");
            $bot->Captcha($chat_id);
            return;
        } else {
            if (!$user['phone_number']) {
                $bot->Captcha($chat_id);
                return;
            }
//            $bot->sendSurveys($chat_id);
//            return;
        }

        $status1 = $bot->isMember2($channelARREY, (int)$chat_id);
        if ($status1 === false) {

            $bot->channel_check2((int)$chat_id, (array)$channelARREY);
//            $users->usersUpdatedata($chat_id, (string)$survey_votes, (string)$name = null, $phone = null);
            return;
        }


        $uservariantID = $survey_votes;

        $survey_id = $suveyVariant->survey_idALL((int )$uservariantID);
        $survey_ID = $survey_id['survey_id'];

        $userID = $users->userID($chat_id);
        $userID = $userID['id'];


        $arrayVotes = $votes->getVotes((int )$userID, (int)$survey_id['survey_id']);

        if ($arrayVotes !== true) {
            $votes->addVOTES((int)$userID, (int)$survey_ID, (int)$uservariantID);
            $bot->sendMessage($chat_id, "so'rovnomada qatnashganingiz uchun katta raxmat...❤️");
            return;
        }
        $bot->sendMessage($chat_id, "Hurmatli foydanalanuvchi bu so'rovnomada oldin qatnashgansiz ..");
        return;

    }


    if (isset($message->contact)) {
        $first_name = $message->contact->first_name ?? '';
        $last_name = $message->contact->last_name ?? '';
        $name = trim("$first_name $last_name");
        $messsage_id = $message->message_id;

        $chat_Id = $message->chat->id;

        $phone = $message->contact->phone_number;


        $channelARREY = $channels->allCHANNEL();

        $link = $users->allLink($chat_Id);


        if ($message->contact->user_id != $chat_Id) {
            $bot->kontagError($chat_Id);
            return;
        } else {
            if ($link === true) {

                $status2 = $bot->isMember2($channelARREY, (int)$chat_id);

                if ($status2 === false) {
                    $bot->channel_check2($chat_Id, $channelARREY);
                    $users->userUpdate((int)$chat_Id, (string)$name, (int)$phone);
                    return;
                }
                $survey_votes = $users->allDATA($chat_Id);


                $uservariantID = $survey_votes['data'];

                $survey_id = $suveyVariant->survey_idALL((int )$uservariantID);
                $survey_ID = $survey_id['survey_id'];

                $userID = $users->userID($chat_id);
                $userID = $userID['id'];


                $arrayVotes = $votes->getVotes((int )$userID, (int)$survey_id['survey_id']);

                if ($arrayVotes !== true) {
                    $votes->addVOTES((int)$userID, (int)$survey_ID, (int)$uservariantID);
                    $bot->removeKeyboard($chat_Id, "so'rovnomada qatnashganingiz uchun katta raxmat...❤️");
                    $users->userUpdate((int)$chat_Id, (string)$name, (int)$phone);


                    $bot->sendMessage($chat_Id, "Ovozingiz qabul qilindi");
                    return;
                }
                $bot->sendMessage($chat_id, "Hurmatli foydanalanuvchi bu so'rovnomada oldin qatnashgansiz ... link 
        ❌\n  boshqa so'rovnomalarda qatnashishingiz mumkun ..");
                return;

            }

            $bot->removeKeyboard($chat_Id, "Sizning ozvozingiz biz uchun muxum");
            $users->userUpdate((int)$chat_Id, (string)$name, (int)$phone);
            $bot->sendSurveys($chat_Id);
        }

    }

}


if (isset($update->callback_query)) {

    $callbackQuery = $update->callback_query;
    $callbackData = $callbackQuery->data;
    $chatId = $callbackQuery->message->chat->id;
    $messageId = $callbackQuery->message->message_id;


    $channelARREY = $channels->allCHANNEL();
    $dataID = $users->allDATA((int )$chatId);


    if ($callbackData == 'tekshirish') {


        $bot->channel_check($chatId, $channelARREY);


        $status = $bot->isMember($channelARREY, (int)$chatId);

        if ($status) {
            $bot->sendVariants2($chatId, $messageId, (int)$dataID['data']);
            return;
        }
    }


    if (strpos($callbackData, 'TEKSHIRISH') !== false) {

        $bot->channel_check2($chatId, $channelARREY);
        $status = $bot->isMember2($channelARREY, (int)$chatId);


        if ($status) {
            $uservariantID = $users->allDATA($chatId);
            $uservariantID = $uservariantID['data'];


            $survey_id = $suveyVariant->survey_idALL($uservariantID);
            $survey_id = $survey_id['survey_id'];

            $userID = $users->userID($chatId);
            $userID = $userID['id'];

            $arrayVotes = $votes->getVotes((int )$userID, (int)$survey_id);
//            var_dump([$userID, $survey_id, $uservariantID]);

            if ($arrayVotes !== true) {
                $votes->addVOTES((int)$userID, (int)$survey_id, (int)$uservariantID);
                $bot->sendMessage($chatId, "So'rovnomada qatnashganingiz uchun katta raxmat...❤️");
                return;
            }
            $bot->sendMessage($chatId, "Hurmatli foydanalanuvchi bu so'rovnomada oldin qatnashgansiz ...
        ❌\n  boshqa so'rovnomalarda qatnashishingiz mumkun...");
            return;


        }
    }

    if (strpos($callbackData, 'id-') !== false) {

        $colbacdata = explode('-', $callbackData);
        $colbacdata = $colbacdata[1];


        $idArray = $surveys->surveysID($colbacdata);

        if ($idArray) {

            $channelARREY = $channels->allCHANNEL();


            $status = $bot->isMember($channelARREY, (int)$chatId);

            $users->addDATA($chatId, $colbacdata);

            if (empty($channelARREY)) {
                $bot->sendVariants2($chatId, $messageId, $colbacdata);
                return;
            }

            if (!$status) {
                $bot->channel_check((int)$chatId, (array)$channelARREY);
                return;
            } else {
                $bot->sendVariants2($chatId, $messageId, $colbacdata);
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

        $bot->sendVariants2($chatId, $messageId, $dataID['data'], $page);
        return;
    }

    if (mb_stripos($callbackData, '_') !== false) {

        $colbacdata = explode('id_', $callbackData);
        $colbacdata = $colbacdata[1];

        $userdata = $users->allDATA($chatId);

        $userID = $users->userID($chatId);
        $userID = $userID['id'];

        $arrayVotes = $votes->getVotes((int )$userID, (int)$userdata['data']);

        if ($arrayVotes) {
            $bot->editMessageText($chatId, $messageId, "Hurmatli foydanalanuvchi bu so'rovnomada oldin qatnashgansiz ... 
        ❌\n  boshqa so'rovnomalarda qatnashishingiz mumkun...");
            exit();
        }
        $votes->addVOTES($userID, (int)$userdata['data'], (int)$colbacdata);
        $bot->editMessageText($chatId, $messageId, "so'rovnomada qatnashganingiz uchun katta raxmat...");
        $url = "https://t.me/share/url?url=https://t.me/{$_ENV['BOT_USERNAME']}?start={$colbacdata}";
        $inlineKeyboard ['inline_keyboard'][] = [['text' => "Havolani ulashish", 'url' => $url]];
        $message = "Quyidagi havolini do'slaringizga ulashishingiz mumkin:";
        $bot->sendMessage($chatId, $message, $inlineKeyboard);
    }

    if (strpos($callbackData, "captcha")) {
        $captcha = $users->allCaptcha($chatId);
        $captcha = $captcha['captcha_code'];

        $colbacdata = explode('-', $callbackData);
        $colbacdata = $colbacdata[0];

        if ($captcha == $colbacdata) {
            $bot->deletmessage($chatId, $messageId);
            $bot->startCommand($chatId);
        } else {
            $bot->deletmessage($chatId, $messageId);
            $bot->Captcha($chatId);
            return;
        }
    }


    if (strpos($callbackData, "ID-") !== false) {
        $colbacdata = explode('-', $callbackData);
        $colbacdata = $colbacdata[1];

        $surveys = (new Votes())->allVotes((int)$colbacdata);

        $statistika = [];

        foreach ($surveys as $survey) {
            $user = (new Survey_variants())->variantNAme($survey->survey_variant_id);

            $num = false;
            foreach ($statistika as &$stat) {
                if ($stat['name'] === $user['name']) {

                    $stat['count'] += 1;
                    $num = true;
                    break;
                }
            }

            if (!$num) {
                $statistika[] = ['name' => $user['name'], 'count' => 1];
            }
        }
        $javob = "";

        $surveyName = (new Surveys())->getSurveyName((int)$colbacdata);
        $javob = "So'rovnoma turi:     " . $surveyName['name'] . "\n";
        $javob .=  "─────────────────────────────────\n";

        unset($stat);
        foreach ($statistika as $stat) {
            $javob .= $stat['name'] . " - " . $stat['count'] . "\n";

        }
        $bot->sendMessage($chatId, $javob);
        $bot -> deletmessage($chatId, $messageId);
        return;
    }
}
