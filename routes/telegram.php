<?php

/** @var SergiX44\Nutgram\Nutgram $bot */

use App\Telegram\Commands\StartCommand;
use App\Telegram\Commands\MainMenu;
use SergiX44\Nutgram\Nutgram;

/*
|--------------------------------------------------------------------------
| Comandi privati (non appaiono nel menu "/")
|--------------------------------------------------------------------------
*/

$bot->registerCommand(StartCommand::class);
$bot->registerCommand(MainMenu::class);

$bot->fallback(fn(Nutgram $bot) => $bot->sendMessage('Non so come aiutarti. Usa /menu'));
