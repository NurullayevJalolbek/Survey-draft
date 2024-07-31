<?php

declare(strict_types=1);

use GuzzleHttp\Client;

require_once "vendor/autoload.php";

class Bot
{
    private string $API;
    private Client $client;

    public function __construct(string $TOKEN)
    {
        $this->API = "https://api.telegram.org/bot$TOKEN/";
        $this->client = new Client(['base_uri' => $this->API]);
    }

    public function startCommand(int $chat_id): void
    {
        $keyboard = [
            'keyboard' => [
                [['text' => 'Send Contact', 'request_contact' => true]]
            ],
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ];
        $this->client->post('sendMessage', [
            'form_params' => [
                'chat_id' => $chat_id,
                'text' => 'raqamingizni yuboring',
                'reply_markup' => json_encode($keyboard),
            ]
        ]);
    }



    public function sendMessage(int $chat_id): void
    {
        $this->client->post('sendMessage', [
            'form_params' => [
                'chat_id' => $chat_id,
                'text' => "Iltimos o'zngizning kontaktingizni yuboring",
            ]
        ]);
    }
    public function inLine(int $chat_id, string $text): void
    {
        $this->client->post('sendMessage', [
            'form_params' => [
                'chat_id' => $chat_id,
                'text' => $text,
            ]
        ]);
    }
}
