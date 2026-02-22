<?php

/** @var SergiX44\Nutgram\Nutgram $bot */

use SergiX44\Nutgram\Nutgram;
use App\Services\TelegramNotificationService;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

/*
|--------------------------------------------------------------------------
| Comandi privati (non appaiono nel menu "/")
|--------------------------------------------------------------------------
*/

$bot->onCommand('start', function (Nutgram $bot) {
    sendChatId($bot);
});

function sendChatId(Nutgram $bot): void
{
    $chatId = $bot->chatId();
    $bot->sendMessage(
        text: "🪪 Chat ID: <b>{$chatId}</b>\n\nUsalo per configurare le notifiche nel pannello admin.",
        parse_mode: ParseMode::HTML,
    );
}

/*
|--------------------------------------------------------------------------
| Navigazione menu
|--------------------------------------------------------------------------
*/

// $bot->onCallbackQueryData('menu', function (Nutgram $bot) {
//     menuPrincipale();
//     $bot->answerCallbackQuery();
// });

// $bot->onCallbackQueryData('menu:reports', function (Nutgram $bot) {
//     $bot->editMessageText(
//         text: '📊 <b>Report</b>',
//         parse_mode: ParseMode::HTML,
//         reply_markup: InlineKeyboardMarkup::make()
//             ->addRow(InlineKeyboardButton::make('👥 Numero Sostenitori', callback_data: 'action:sostenitori'))
//             ->addRow(InlineKeyboardButton::make('📅 Adesioni per anno', callback_data: 'action:adesioni'))
//             ->addRow(InlineKeyboardButton::make('⬅️ Indietro', callback_data: 'menu:main')),
//     );
//     $bot->answerCallbackQuery();
// });

/*
|--------------------------------------------------------------------------
| Azioni
|--------------------------------------------------------------------------
*/

// $bot->onCallbackQueryData('action:sostenitori', function (Nutgram $bot) {
//     app(TelegramNotificationService::class)->summarySostenitori($bot->chat()->id);
//     $bot->answerCallbackQuery();
// });

// $bot->onCallbackQueryData('action:adesioni', function (Nutgram $bot) {
//     app(TelegramNotificationService::class)->summaryAdesioni($bot->chat()->id);
//     $bot->answerCallbackQuery();
// });

// $bot->onCallbackQueryData('action:chat-id', function (Nutgram $bot) {
//     sendChatId($bot);
//     $bot->answerCallbackQuery();
// });

/*
|--------------------------------------------------------------------------
| Fallback
|--------------------------------------------------------------------------
*/

$bot->fallback(fn (Nutgram $bot) => $bot->sendMessage('Non so come aiutarti. Usa /menu'));

/*
|--------------------------------------------------------------------------
| Helper locali
|--------------------------------------------------------------------------
*/

// function menuPrincipale(): InlineKeyboardMarkup
// {
//     return InlineKeyboardMarkup::make()
//         ->addRow(InlineKeyboardButton::make('📊 Report', callback_data: 'menu:reports'))
//         ->addRow(InlineKeyboardButton::make('🪪 Chat ID', callback_data: 'action:chat-id'));
// }
