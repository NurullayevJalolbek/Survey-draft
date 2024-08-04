<?php

declare(strict_types=1);
require_once "vendor/autoload.php";

use GuzzleHttp\Client;

require_once "src/Surveys.php";


class Bot
{
    private string $API;
    private Client $client;
    public Surveys $surves;
    public Survey_variants $surves_variant;

    public function __construct(string $TOKEN)
    {
        $this->API = "https://api.telegram.org/bot$TOKEN/";
        $this->client = new Client(['base_uri' => $this->API]);
        $this->surves = new Surveys();
        $this->surves_variant = new Survey_variants();
    }
    public function sendMessage(int $chat_id, $text, $reply_markup = null): void
    {
        $content = [
            'form_params' => [
                'chat_id' => $chat_id,
                'text' => $text,
            ]
        ];
        $reply_markup ? $content['form_params']['reply_markup'] = json_encode($reply_markup) : null;
        $this->client->post('sendMessage', $content);
    }


    public function editMessageText(int $chat_id, int $message_id, string $text, $reply_markup = null): void
    {

        $content = [
            'form_params' => [
                'chat_id' => $chat_id,
                'message_id' => $message_id,
                'text' => $text
            ]
        ];
        $reply_markup ? $content['form_params']['reply_markup'] = json_encode($reply_markup) : null;
        $this->client->post('editMessageText', $content);
    }

    public function startCommand(int $chat_id): void
    {
        $keyboard = [
            'keyboard' => [
                [['text' => 'Send Contact', 'request_contact' => true]]
            ],
            'resize_keyboard' => true,
            'one_time_keyboard' => true,
        ];
        $this->sendMessage($chat_id, '📲  Kontagingizni yuboring', $keyboard);
    }

    public function kontagError($chat_id): void
    {
        $this->sendMessage($chat_id, "📱 Iltimos Xurmatli foydalanuvchi o'zingizni kontagingizni yuoboring..🛠❌");
    }

    public function sendArray(int $chat_id, $arrayy): void
    {
        $this->sendMessage($chat_id, print_r($arrayy, true));
    }

    public function sendSurveys(int $chat_id): void
    {
        $malumotlar = $this->surves->surveysAll();
        $inline_keybord = array();
        $row = array();

        foreach ($malumotlar as $item) {
            $row[] = ["text" => "{$item['name']}", "callback_data" => "id-{$item['id']}"];

            if (count($row) == 3) {
                $inline_keybord[] = $row;
                $row = array();
            }
        }

        if (!empty($row)) {
            $inline_keybord[] = $row;
        }
        $keyboard = [
            'inline_keyboard' => $inline_keybord
        ];
        $this->sendMessage($chat_id, "Qaysi so'rovnomalarda qatnashmoqchisisz...✏️", $keyboard);
    }

    public function removeKeyboard(int $chat_id): void
    {
        $this->sendMessage($chat_id, "Sizning ovozingiz biz uchun muhum.....!", ['remove_keyboard' => true]);
    }

    public function sendVariants(int $chat_id, $message_id, $votesId): void
    {
        $surveyarray = $this->surves_variant->survey_variantsAll($votesId);

        $malumotlar = [];
        $inline_keybord = array();

        foreach ($surveyarray as $item) {
            $malumotlar[] = ["text" => "{$item['name']}", "callback_data" => "id_{$item['id']}"];

            if (count($malumotlar) == 3) {
                $inline_keybord[] = $malumotlar;
                $malumotlar = array();
            }
        }

        if (!empty($malumotlar)) {
            $inline_keybord[] = $malumotlar;
        }

        $this->editMessageText($chat_id, $message_id, 'Hohlagan bittasiga ovoz berishingiz mumkun...', ['inline_keyboard' => $inline_keybord]);
    }

    public function deleteMessage(int $chat_id, int $message_id): void // DELET MESSAGE 
    {
        $this->client->post('deleteMessage', [
            'form_params' => [
                'chat_id' => $chat_id,
                'message_id' => $message_id
            ]
        ]);
    }

    public function isMember(int $chat_id, int $user_id)
    {
        $response = $this->client->post('getChatMember', [
            'form_params' => [
                'chat_id' => $chat_id,
                'user_id' => $user_id
            ]
        ]);

        $body = $response->getBody()->getContents();
        $result = json_decode($body, true);

        return $result['result']['status'];
    }

    public function channel_check(int $chat_id): void
    {
        $chanelID = -1002170814544; // Kanal yoki guruh ID
        $status = $this->isMember($chanelID, $chat_id);

        if ($status !== 'member' && $status !== 'administrator' && $status !== 'creator') {
            $inlineKeyboard = [
                'inline_keyboard' => [
                    [
                        ['text' => "Kanalga azo Bo'ling  ", 'url' => 'https://t.me/project_bot2004']
                    ],
                    [
                        ['text' => "Tekshirish ✅", 'callback_data' => "tekshirish"]
                    ]
                ]
            ];
            $text = "Kanalga AZO bo'lishingiz TALAB qilinadi....❌   Quyidagi tugmani bosing:";
            $this->sendMessage($chat_id, $text, $inlineKeyboard);
        }
    }
}
