<?php

/** @var SergiX44\Nutgram\Nutgram $bot */

use SergiX44\Nutgram\Nutgram;
use App\Telegram\Menus\MainMenu;
use App\Telegram\Commands\StartCommand;

/*
|--------------------------------------------------------------------------
| Comandi privati (non appaiono nel menu "/")
|--------------------------------------------------------------------------
*/

$bot->registerCommand(StartCommand::class);
$bot->registerCommand(MainMenu::class);

$bot->fallback(fn (Nutgram $bot) => $bot->sendMessage('Non so come aiutarti. Usa /menu'));
