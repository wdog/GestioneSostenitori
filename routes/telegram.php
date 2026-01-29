<?php

/** @var SergiX44\Nutgram\Nutgram $bot */

use SergiX44\Nutgram\Nutgram;

/*
|--------------------------------------------------------------------------
| Nutgram Handlers
|--------------------------------------------------------------------------
|
| Here is where you can register telegram handlers for Nutgram. These
| handlers are loaded by the NutgramServiceProvider. Enjoy!
|
*/

$bot->onCommand('start', function (Nutgram $bot) {
    $chatId = $bot->chatId();
    $bot->sendMessage("Ciao! Il tuo Chat ID è: <b>{$chatId}</b>\n\nUsalo per configurare le notifiche nel pannello admin.", parse_mode: \SergiX44\Nutgram\Telegram\Properties\ParseMode::HTML);
})->description('The start command!');
