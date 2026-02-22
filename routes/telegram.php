<?php

/** @var SergiX44\Nutgram\Nutgram $bot */

use App\Telegram\Menus\MainMenu;
use App\Telegram\Commands\StartCommand;
use App\Telegram\Middleware\AuthorizeChat;

$bot->registerCommand(StartCommand::class);

$bot->onCommand('menu', MainMenu::class)
    ->description('Apri il menu principale')
    ->middleware(AuthorizeChat::class);
