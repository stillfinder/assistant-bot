<?php

use App\Http\Controllers\BotManController;
use BotMan\BotMan\Middleware\Dialogflow;

$botman = resolve('botman');

$dialogFlow = DialogFlow::create('80461b1eed38401cb1ba55ea9b6d13ee')->listenForAction();

$botman->middleware->received($dialogFlow);

$botman->hears('findshow', function ($bot) {
    $extras = $bot->getMessage()->getExtras();
    $keyword = $extras['apiParameters']['any'];
    $url = 'http://api.tvmaze.com/singlesearch/shows?q=' . urlencode($keyword);
    $response = json_decode(file_get_contents($url));

    $bot->reply('That what I found: ' . $response->name);
})->middleware($dialogFlow);
