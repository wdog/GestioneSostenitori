<?php

namespace App\Telegram\Commands;

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;

/**
 * Comando /start
 * Mostra il bottone principale "📋 Menu"
 */
class StartCommand extends Command
{
    protected string $command = 'start';

    // protected ?string $description = 'Avvia il bot';

    public function handle(Nutgram $bot): void
    {
        // Creiamo una tastiera fissa sotto l'input
        $keyboard = ReplyKeyboardMarkup::make(resize_keyboard: true)
            ->addRow('📋 Menu');

        $chatId = $bot->chatId();
        $bot->sendMessage(
            text: "🪪 Chat ID: <b>{$chatId}</b>\n\nUsalo per configurare le notifiche nel pannello admin.",
            parse_mode: ParseMode::HTML,
            reply_markup: $keyboard,
        );
    }
}
