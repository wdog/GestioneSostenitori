<?php

/** @var SergiX44\Nutgram\Nutgram $bot */

use SergiX44\Nutgram\Nutgram;
use App\Telegram\Menus\MainMenu;
use App\Telegram\Commands\StartCommand;

$bot->registerCommand(StartCommand::class);

$bot->onCommand('menu', MainMenu::class)
    ->description('Apri il menu principale');


$bot->fallback(function (Nutgram $bot) {
    $text = $bot->message()?->text ?? '';
    if (str_starts_with($text, '/')) {
        $bot->sendMessage('Non so come farlo. Prova a cercare nel /menu.');
    }
});
