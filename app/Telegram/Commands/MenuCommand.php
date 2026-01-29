<?php

namespace App\Telegram\Commands;

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Handlers\Type\Command;
use App\Services\TelegramNotificationService;

class MenuCommand extends Command
{
    protected string $command = 'main-menu';

    protected ?string $description = 'Show main menu.';

    public function handle(Nutgram $bot): void
    {
        app(TelegramNotificationService::class)
            ->menu($bot->chat()->id);
    }
}
