<?php

/** @var SergiX44\Nutgram\Nutgram $bot */

use App\Telegram\Commands\StartCommand;
use App\Telegram\Menus\MainMenu;


$bot->registerCommand(StartCommand::class);

$bot->onCommand('menu', MainMenu::class)
    ->description('Apri il menu principale');
