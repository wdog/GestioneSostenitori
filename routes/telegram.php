<?php

/** @var SergiX44\Nutgram\Nutgram $bot */

use SergiX44\Nutgram\Nutgram;
use App\Telegram\Menus\MainMenu;
use App\Telegram\Commands\StartCommand;

$bot->registerCommand(StartCommand::class);

$bot->onCommand('menu', MainMenu::class)
    ->description('Apri il menu principale');

$bot->group(
    fn (Nutgram $bot) => $bot->onCommand('menu', MainMenu::class),
);

$bot->fallback(fn (Nutgram $bot) => $bot->sendMessage('Non so come farlo. Prova a cercare nel /menu.'));
