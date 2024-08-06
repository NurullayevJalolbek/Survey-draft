<?php

declare(strict_types=1);

use GuzzleHttp\Client;

require_once "vendor/autoload.php";
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







    public function sendSurveys(int $chat_id, int $page = 1): void
    {
        $malumotlar = $this->surves->surveysAll();
        $surveysPerPage = 10;
        $totalSurveys = count($malumotlar);
        $totalPages = ceil($totalSurveys / $surveysPerPage);

        $start = ($page - 1) * $surveysPerPage;
        $end = min($start + $surveysPerPage, $totalSurveys);

        $inline_keyboard = array();
        $row = array();

        for ($i = $start; $i < $end; $i++) {
            $item = $malumotlar[$i];
            $row[] = ["text" => "{$item['name']}", "callback_data" => "id-{$item['id']}"];

            if (count($row) == 2) {
                $inline_keyboard[] = $row;
                $row = array();
            }
        }

        if (!empty($row)) {
            $inline_keyboard[] = $row;
        }

        // Add pagination buttons
        $paginationRow = array();
        if ($page > 1) {
            $paginationRow[] = ["text" => "⬅️ Back", "callback_data" => "page-" . ($page - 1)];
        }
        if ($page < $totalPages) {
            $paginationRow[] = ["text" => "Forward ➡️", "callback_data" => "page-" . ($page + 1)];
        }
        if (!empty($paginationRow)) {
            $inline_keyboard[] = $paginationRow;
        }

        $keyboard = [
            'inline_keyboard' => $inline_keyboard
        ];

        $messageText = "Qaysi so'rovnomalarda qatnashmoqchisisz...✏️\n\n";
        $messageText .= "Sahifa: $page/$totalPages";

        $this->sendMessage($chat_id, $messageText, $keyboard);
    }








    public function sendSurveys2(int $chat_id, $message_id, int $page = 1): void
    {
        $malumotlar = $this->surves->surveysAll();
        $surveysPerPage = 10;
        $totalSurveys = count($malumotlar);
        $totalPages = ceil($totalSurveys / $surveysPerPage);

        $start = ($page - 1) * $surveysPerPage;
        $end = min($start + $surveysPerPage, $totalSurveys);

        $inline_keyboard = array();
        $row = array();

        for ($i = $start; $i < $end; $i++) {
            $item = $malumotlar[$i];
            $row[] = ["text" => "{$item['name']}", "callback_data" => "id-{$item['id']}"];

            if (count($row) == 2) {
                $inline_keyboard[] = $row;
                $row = array();
            }
        }

        if (!empty($row)) {
            $inline_keyboard[] = $row;
        }

        $paginationRow = array();
        if ($page > 1) {
            $paginationRow[] = ["text" => "⬅️ Back", "callback_data" => "page-" . ($page - 1)];
        }
        if ($page < $totalPages) {
            $paginationRow[] = ["text" => "Forward ➡️", "callback_data" => "page-" . ($page + 1)];
        }
        if (!empty($paginationRow)) {
            $inline_keyboard[] = $paginationRow;
        }

        $keyboard = [
            'inline_keyboard' => $inline_keyboard
        ];

        $messageText = "Qaysi so'rovnomalarda qatnashmoqchisisz...✏️\n\n";
        $messageText .= "Sahifa: $page/$totalPages";

        $this->editMessageText($chat_id, $message_id, $messageText, $keyboard);
    }








    public function removeKeyboard(int $chat_id): void
    {
        $this->sendMessage($chat_id, "Sizning ovozingiz biz uchun muhum.....!", ['remove_keyboard' => true]);
    }







    public function sendVariants(int $chat_id, $message_id, $votesId, int $page = 1): void
    {
        $variantsPerPage = 10;
        $surveyarray = $this->surves_variant->survey_variantsAll($votesId);
        $totalVariants = count($surveyarray);
        $totalPages = ceil($totalVariants / $variantsPerPage);



        $start = ($page - 1) * $variantsPerPage;
        $end = min($start + $variantsPerPage, $totalVariants);

        $malumotlar = [];
        $inline_keybord = [];

        for ($i = $start; $i < $end; $i++) {
            $item = $surveyarray[$i];
            $malumotlar[] = ["text" => "{$item['name']}", "callback_data" => "id_{$item['id']}"];

            if (count($malumotlar) == 2) {
                $inline_keybord[] = $malumotlar;
                $malumotlar = [];
            }
        }

        if (!empty($malumotlar)) {
            $inline_keybord[] = $malumotlar;
        }

        $paginationRow = [];
        if ($page > 1) {
            $paginationRow[] = ["text" => "⬅️ Back", "callback_data" => "page_" . ($page - 1)];
        }
        if ($page < $totalPages) {
            $paginationRow[] = ["text" => "Forward ➡️", "callback_data" => "page_" . ($page + 1)];
        }
        if (!empty($paginationRow)) {
            $inline_keybord[] = $paginationRow;
        }

        $keyboard = [
            'inline_keyboard' => $inline_keybord
        ];

        $messageText = 'Hohlagan bittasiga ovoz berishingiz mumkun...\n';
        $messageText .= "\n\nSahifa: $page/$totalPages";


        $this->editMessageText($chat_id, $message_id, $messageText, $keyboard);
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

   public function getChat($chat_id)
   {
       $response = $this->client->post('https://api.telegram.org/bot' . $_ENV['TOKEN'] . '/getChat',
           ['json' => ['chat_id' => $chat_id]] );

       $responseBody = $response->getBody()->getContents();
       $result = json_decode($responseBody, true);

       return $result;

   }







   public function votes(int $chat_id, $message_id): void
   {

       $this->editMessageText($chat_id, $message_id, "so'rovnomada qatnashganingiz uchun katta raxmat...❤️");
   }


//    public function votesERROR($chat_id, $message_id): void
//    {
//
//        $this->editMessageText($chat_id, $message_id, "Hurmatli foydanalanuvchi bu ro'rovnomada oldin qatnashgansiz ... ❌\n  boshqa so'rovnomalarda qatnashmoqchi bo'lsangiz  /sorovnomalar komandasini kiriting");
//    }
}
