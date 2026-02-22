<?php

namespace App\Telegram\Commands;

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;

class MainMenu extends Command
{
    protected string $command = 'menu';

    // protected ?string $description = 'Apri il menu principale';

    public function handle(Nutgram $bot): void
    {
        $keyboard = ReplyKeyboardMarkup::make(resize_keyboard: true)
            ->addRow('ActionA', 'ActionB');

        $bot->sendMessage(
            'Menu principale:',
            reply_markup: $keyboard
        );
    }
}
