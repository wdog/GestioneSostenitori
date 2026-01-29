<?php

/** @var SergiX44\Nutgram\Nutgram $bot */

use SergiX44\Nutgram\Nutgram;
use App\Telegram\Commands\menu;
use App\Telegram\Commands\MenuCommand;
use App\Services\TelegramNotificationService;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;

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
})
    ->description('The start command!');


$bot->onCommand('menu', MenuCommand::class)
    ->description('The menu command!');

$bot->onCallbackQuery(function (Nutgram $bot) {
    $service = app(TelegramNotificationService::class);
    $chatId  = $bot->chat()->id;
    $data    = $bot->callbackQuery()->data;
    match ($data) {
        'menu:summary_sostenitori' => $service->summarySostenitori($chatId),
        'menu:summary_adesioni'    => $service->summaryAdesioni($chatId),
        default               => null,
    };
    $bot->sendMessage("👍", parse_mode: ParseMode::HTML);
    $bot->answerCallbackQuery();
});

$bot->fallback(fn(Nutgram $bot) => $bot->sendMessage('Non so come aiutarti. Prova /menu'));
