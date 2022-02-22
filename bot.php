<?php

require './settings.php';
use App\Core\Telegram;


$bot = new Telegram('TOKEN');

$results = $bot->getData();
$chat_id = $bot->ChatID();
$text = strtolower($bot->Text());
$first_name = $bot->FirstName();

if ($text == '/start') {

    $message = str_replace([
        '{name}',
        '            '
    ], [
        $first_name,
        ''
    ], $messages['pv']['start']);

    $bot->sendMessage([
        'chat_id' => $chat_id,
        'text' => $message,
        'parse_mode' => 'HTML'
    ]);

} elseif (str_contains($text, '/create')) {

    $create_text = explode('/create', $text)[1];

    $data = [ 'text' => $create_text ];
    $data = http_build_query($data);

    $image = 'https://fake-ye-bot-api.herokuapp.com/generate.php?' . $data;

    $bot->sendPhoto([
        'chat_id' => $chat_id,
        'photo' => $image,
    ]);

    $bot->sendMessage([
        'chat_id' => $chat_id,
        'text' => "Successfull!",
    ]);
}

if (isset($results['inline_query'])) {

    $id = $results['inline_query']['id'];
    $query_data = $results['inline_query']['query'];

    $data = [ 'text' => $query_data ];
    $data = http_build_query($data);

    $image = 'https://fake-ye-bot-api.herokuapp.com/generate.php?' . $data;

    $inline_query_result = [
        'type' => 'photo',
        'id' => base64_encode(mt_rand()),
        'photo_url' => $image,
        'thumb_url' => $image
    ];

    $bot->answerInlineQuery([

        'inline_query_id' => $id,
        'results' => json_encode([
            $inline_query_result
        ]),

        'cache_time' => 0,
        'is_personal' => false,

    ]);
}