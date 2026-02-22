<?php

/** @var SergiX44\Nutgram\Nutgram $bot */

use App\Telegram\Commands\StartCommand;
use App\Telegram\Menus\MainMenu;
use Illuminate\Support\Facades\Log;
use SergiX44\Nutgram\Nutgram;

$bot->registerCommand(StartCommand::class);

$bot->onCommand('menu', MainMenu::class)
    ->description('Apri il menu principale');


$bot->fallback(function (Nutgram $bot) {
    $text = $bot->message()?->text ?? '';
    Log::debug($text);
    if (str_starts_with($text, '/')) {
        Log::debug("MATCH " . $text);
        $bot->sendMessage('Non so come farlo. Prova a cercare nel /menu.');
    }
});
