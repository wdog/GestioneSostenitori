<?php

namespace App\Telegram\Commands;

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;

class StartCommand extends Command
{
    protected string $command = 'start';

    public function handle(Nutgram $bot): void
    {
        $chatId = $bot->chatId();

        $bot->sendMessage(
            text: "Chat ID: <b>{$chatId}</b>\n\nUsalo per configurare le notifiche nel pannello admin.",
            parse_mode: ParseMode::HTML,
        );
    }
}
