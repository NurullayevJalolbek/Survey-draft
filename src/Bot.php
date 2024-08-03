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
    public function sendMessage(int $chat_id, $text, $reply_markup=null): void{
        $content = [
            'form_params' => [
                'chat_id' => $chat_id,
                'text' => $text,
            ]
        ];
        $reply_markup ? $content['form_params']['reply_markup'] = json_encode($reply_markup) : null;
        $this->client->post('sendMessage', $content);
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
        $this -> sendMessage($chat_id,'Kontagingizni yuboring', $keyboard);
    }


    public function  kontagMessage($chat_id):void
    {
        $this -> sendMessage($chat_id, 'Kontagingizni yuboring');
    }

    public function  kontagError($chat_id):void
    {
      $this -> sendMessage($chat_id, "Iltimos Xurmatli foydalanuvchi o'zingizni kontagingizni yuoboring");
    }

    public function sendArray(int $chat_id, $arrayy): void  {
        $this->sendMessage($chat_id, print_r($arrayy, true));
    }
    public function sendSurveys(int $chat_id): void {
        $malumotlar = $this->surves->surveysAll();

        $inline_keybord = array();
        $row = array();

        foreach ($malumotlar as $item) {
            $row[] = ["text" => "{$item['name']}", "callback_data" => "id-{$item['id']}"];

            if (count($row) == 2) {
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
    public function removeKeyboard(int $chat_id): void{
        $this->sendMessage($chat_id, "Siz muvoffaqiyatli ro'yxatdan o'tdingiz......✅", ['remove_keyboard' => true]);
    }
    public function sendVariants(int $chat_id, $votesId): void{
        $surveyarray = $this->surves_variant->survey_variantsAll($votesId);

        $malumotlar = [];
        $inline_keybord = array();

        foreach ($surveyarray as $item) {
            $malumotlar[] = ["text" => "{$item['name']}", "callback_data" => "id-{$item['id']}"];

            if (count($malumotlar) == 2) {
                $inline_keybord[] = $malumotlar;
                $malumotlar= array();
            }
        }

        if (!empty($malumotlar)) {
            $inline_keybord[] = $malumotlar;
        }

        $this->sendMessage($chat_id, '...', ['inline_keyboard' => $inline_keybord]);

    }
}
