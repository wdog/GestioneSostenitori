<?php

/** @var SergiX44\Nutgram\Nutgram $bot */

use SergiX44\Nutgram\Nutgram;
use App\Telegram\Commands\MenuCommand;
use App\Services\TelegramNotificationService;

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
    $bot->sendMessage(
        text: "Ciao valoroso Prog Lover! Il tuo personal Chat ID è: <b>{$chatId}</b>\n\nUsalo per configurare le notifiche nel pannello admin.",
        parse_mode: \SergiX44\Nutgram\Telegram\Properties\ParseMode::HTML,
    );
})
    ->description('Il tuo ID');

$bot->onCommand('id', function (Nutgram $bot) {
    $chatId = $bot->chatId();
    $bot->sendMessage(
        text: "Group Chat ID: <b>{$chatId}</b>\n\nUsalo per configurare le notifiche nel pannello admin.",
        parse_mode: \SergiX44\Nutgram\Telegram\Properties\ParseMode::HTML,
    );
})
    ->description('ID di questa chat');

$bot->onCommand('menu', MenuCommand::class)
    ->description('Menu Principale');

$bot->onCallbackQuery(function (Nutgram $bot) {
    $service = app(TelegramNotificationService::class);
    $chatId  = $bot->chat()->id;
    $data    = $bot->callbackQuery()->data;
    match ($data) {
        'menu:summary_sostenitori' => $service->summarySostenitori($chatId),
        'menu:summary_adesioni'    => $service->summaryAdesioni($chatId),
        default                    => null,
    };
    $bot->answerCallbackQuery();
});

$bot->fallback(fn (Nutgram $bot) => $bot->sendMessage('Non so come aiutarti. Prova /menu'));
