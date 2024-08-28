<?php

declare(strict_types=1);

use GuzzleHttp\Client;

require_once "vendor/autoload.php";
require_once "src/Surveys.php";
require_once "src/Users.php";


class Bot
{
    private string $API;
    private Client $client;
    public Surveys $surves;
    public Survey_variants $surves_variant;
    public Users $users;

    public function __construct(string $TOKEN)
    {
        $this->API = "https://api.telegram.org/bot$TOKEN/";
        $this->client = new Client(['base_uri' => $this->API]);
        $this->surves = new Surveys();
        $this->surves_variant = new Survey_variants();
        $this->users = new Users();
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

        $paginationRow = array();
        if ($page > 1) {
            $paginationRow[] = ["text" => "⬅️ Orqaga ", "callback_data" => "page-" . ($page - 1)];
        }
        if ($page < $totalPages) {
            $paginationRow[] = ["text" => "Oldinga  ➡️", "callback_data" => "page-" . ($page + 1)];
        }

        if (!empty($paginationRow)) {
            $inline_keyboard[] = $paginationRow;
        }

        $keyboard = [
            'inline_keyboard' => $inline_keyboard
        ];

        $messageText = "Qaysi so'rovnomalarda qatnashmoqchisisz...✏️\n\n";
        $messageText .= "Sahifalar soni : $page/$totalPages";

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
            $paginationRow[] = ["text" => "⬅️ Orqaga", "callback_data" => "page-" . ($page - 1)];
        }
        if ($page < $totalPages) {
            $paginationRow[] = ["text" => "Oldinga ➡️", "callback_data" => "page-" . ($page + 1)];
        }
        if (!empty($paginationRow)) {
            $inline_keyboard[] = $paginationRow;
        }

        $keyboard = [
            'inline_keyboard' => $inline_keyboard
        ];

        $messageText = "Qaysi so'rovnomalarda qatnashmoqchisisz...✏️\n\n";
        $messageText .= "Sahifalar soni : $page/$totalPages";

        $this->editMessageText($chat_id, $message_id, $messageText, $keyboard);
    }


    public function removeKeyboard(int $chat_id, $text): void
    {
        $this->sendMessage($chat_id, $text, ['remove_keyboard' => true]);
        sleep(1);
    }


    public function sendVariants2(int $chat_id, $message_id, $votesId, int $page = 1): void
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
            $paginationRow[] = ["text" => "⬅️ orqaga", "callback_data" => "page_" . ($page - 1)];
        }
        if ($page < $totalPages) {
            $paginationRow[] = ["text" => "Oldinga ➡️", "callback_data" => "page_" . ($page + 1)];
        }
        if (!empty($paginationRow)) {
            $inline_keybord[] = $paginationRow;
        }

        $keyboard = [
            'inline_keyboard' => $inline_keybord
        ];

        $messageText = 'Hohlagan bittasiga ovoz berishingiz mumkun...\n';
        $messageText .= "\n\nSahifalar soni : $page/$totalPages";


        $this->editMessageText($chat_id, $message_id, $messageText, $keyboard);
    }


    public function isMember(array $channel_ids, int $user_id): bool
    {
        foreach ($channel_ids as $channel) {
            $response = $this->client->post('https://api.telegram.org/bot' . $_ENV['BOT_TOKEN'] . '/getChatMember', [
                'json' => [
                    'chat_id' => (int)$channel['channel_id'],
                    'user_id' => $user_id
                ]
            ]);
            $body = $response->getBody()->getContents();
            $result = json_decode($body, true);

            if (isset($result['result']['status'])) {
                $status = $result['result']['status'];
                if ($status !== 'member' && $status !== 'administrator' && $status !== 'creator') {
                    return false;
                }
            } else {
                return false;
            }
        }

        return true;
    }


    public function getChat(int $chat_id)
    {
        $response = $this->client->post(
            'https://api.telegram.org/bot' . $_ENV['BOT_TOKEN'] . '/getChat',
            ['json' => ['chat_id' => $chat_id]]
        );

        $responseBody = $response->getBody()->getContents();
        $result = json_decode($responseBody, true);

        return $result['result'];
    }

    public function channel_check(int $chat_id, array $channel_id): void
    {
        $status = $this->isMember($channel_id, $chat_id);

        if (!$status) {
            $channels = [];
            foreach ($channel_id as $channel) {
                $channel_info = $this->getChat($channel['channel_id']);
                $channels[] = [
                    'title' => $channel_info['title'],
                    'url' => $channel_info['invite_link']
                ];
            }

            $inlineKeyboard = [];
            foreach ($channels as $channel) {
                $inlineKeyboard['inline_keyboard'][] = [
                    ['text' => $channel['title'], 'url' => $channel['url']]
                ];
            }
            $inlineKeyboard['inline_keyboard'][] = [
                ['text' => "Tekshirish ✅", 'callback_data' => "tekshirish"]
            ];

            $text = "Kanalga AZO bo'lishingiz TALAB qilinadi....❌   Quyidagi tugmani bosing:";
            $this->sendMessage($chat_id, $text, $inlineKeyboard);
        }
    }


    public function isMember2(array $channel_ids, int $user_id): bool
    {
        foreach ($channel_ids as $channel) {
            $response = $this->client->post('https://api.telegram.org/bot' . $_ENV['BOT_TOKEN'] . '/getChatMember', [
                'json' => [
                    'chat_id' => (int)$channel['channel_id'],
                    'user_id' => $user_id
                ]
            ]);

            $body = $response->getBody()->getContents();
            $result = json_decode($body, true);

            if (isset($result['result']['status'])) {
                $status = $result['result']['status'];
                if ($status !== 'member' && $status !== 'administrator' && $status !== 'creator') {
                    return false;
                }
            } else {
                return false;
            }
        }

        return true;
    }


    public function getChat2(int $chat_id)
    {
        $response = $this->client->post(
            'https://api.telegram.org/bot' . $_ENV['BOT_TOKEN'] . '/getChat',
            ['json' => ['chat_id' => $chat_id]]
        );

        $responseBody = $response->getBody()->getContents();
        $result = json_decode($responseBody, true);

        return $result['result'];
    }

    public function channel_check2(int $chat_id, array $channel_id): void
    {
        $status = $this->isMember2($channel_id, $chat_id);

        if (!$status) {
            $channels = [];
            foreach ($channel_id as $channel) {
                $channel_info = $this->getChat2($channel['channel_id']);
                $channels[] = [
                    'title' => $channel_info['title'],
                    'url' => $channel_info['invite_link']
                ];
            }

            $inlineKeyboard = [];
            foreach ($channels as $channel) {
                $inlineKeyboard['inline_keyboard'][] = [
                    ['text' => $channel['title'], 'url' => $channel['url']]
                ];
            }
            $inlineKeyboard['inline_keyboard'][] = [
                ['text' => "TEKSHIRISH✅", 'callback_data' => "TEKSHIRISH"]
            ];

            $text = "Kanalga AZO bo'lishingiz TALAB qilinadi....❌   Quyidagi tugmani bosing:";
            $this->sendMessage($chat_id, $text, $inlineKeyboard);
        }
    }


    public function Captcha($chat_id)
    {
        $jpg_image = imagecreatefromjpeg('IMAGE_FONT/cap.jpg');



        $YozuvRangi = imagecolorallocate($jpg_image, 0, 0, 0);
        $chiziqlarRangi = imagecolorallocate($jpg_image, 0, 0, 0);



        $randmonson = rand(1000, 9999);

        $this->users->addCaptcha($randmonson, $chat_id);

        $font_path = 'IMAGE_FONT/FONT.ttf';

        $textRazmeri = 45;
        $yozuvningBurchagi = 20;

        $image_kengligi = imagesx($jpg_image);
        $image_balandligi = imagesy($jpg_image);

        $matnRazmeri = imagettfbbox($textRazmeri, $yozuvningBurchagi, $font_path, (string)$randmonson);
        $text_kengligi = abs($matnRazmeri[4] - $matnRazmeri[0]);
        $text_balandlik = abs($matnRazmeri[5] - $matnRazmeri[1]);

        $x = ($image_kengligi - $text_kengligi) / 2;
        $y = ($image_balandligi - $text_balandlik) / 2 + $text_balandlik;

        for ($i = 0; $i < 15; $i++) {
            $x1 = rand(0, $image_kengligi);
            $y1 = rand(0, $image_balandligi);
            $x2 = rand(0, $image_kengligi);
            $y2 = rand(0, $image_balandligi);
            imageline($jpg_image, $x1, $y1, $x2, $y2, $chiziqlarRangi);
        }

        imagettftext($jpg_image, $textRazmeri, $yozuvningBurchagi, (int)$x, (int)$y, $YozuvRangi, $font_path, (string)$randmonson);

        $temp_file = tempnam(sys_get_temp_dir(), 'captcha') . '.jpg';
        imagejpeg($jpg_image, $temp_file);

        $this->sendPhoto($chat_id, $temp_file);

        imagedestroy($jpg_image);

        unlink($temp_file);
    }


    public function sendPhoto($chat_id, $photoPath)
    {
        $chaptchason = $this->users->allCaptcha($chat_id);
        $captcha_code = $chaptchason['captcha_code'];

        $son1 = rand(1000, 9999);
        $son2 = rand(1000, 9999);
        $son3 = rand(1000, 9999);

        $buttons = [
            ['text' => $son1, 'callback_data' => "$son1-captcha"],
            ['text' => $son2, 'callback_data' => "$son2-captcha"],
            ['text' => $son3, 'callback_data' => "$son3-captcha"],
            ['text' => $captcha_code, 'callback_data' => "$captcha_code-captcha"]

        ];

        shuffle($buttons);
        $inlineKeyboard = [
            'inline_keyboard' => array_chunk($buttons, 2) // Create rows of 2 buttons each
        ];

        $url = "https://api.telegram.org/bot" . $_ENV['BOT_TOKEN'] . "/sendPhoto";

        $response = $this->client->post($url, [
            'multipart' => [
                [
                    'name' => 'chat_id',
                    'contents' => $chat_id
                ],
                [
                    'name' => 'photo',
                    'contents' => fopen($photoPath, 'r'),
                    'filename' => basename($photoPath)
                ],
                [
                    'name' => 'reply_markup',
                    'contents' => json_encode($inlineKeyboard)
                ]
            ]
        ]);

        $body = $response->getBody()->getContents();
        return json_decode($body, true);
    }


    public function deletmessage( $chat_id, $message_id)
    {
        $this-> client->post("https://api.telegram.org/bot".$_ENV['BOT_TOKEN']."/deleteMessage", [
            'form_params' => [
                'chat_id' => $chat_id,
                'message_id' => $message_id,
            ]
        ]);
    }

}
