<?php

namespace App\Telegram\Middleware;

use App\Models\User;
use App\Models\Impostazione;
use SergiX44\Nutgram\Nutgram;

/**
 * Blocca l'accesso al bot ai soli chat ID configurati nel pannello admin
 * (utenti personali o gruppi il cui chat ID è salvato in users.telegram_chat_id).
 */
class AuthorizeChat
{
    public function __invoke(Nutgram $bot, callable $next): void
    {
        // ID della chat corrente (gruppo o privato) e dell'utente che scrive
        // ! gruppo
        $chatId = (string) $bot->chatId();
        // ! utente
        $userId = (string) $bot->userId();

        // ID del gruppo configurato nelle impostazioni globali
        $groupIdImpostazioni = (string) Impostazione::get('telegram_group_chat_id');

        // ID dei singoli utenti configurati nel pannello admin
        $userIds = User::whereNotNull('telegram_chat_id')->pluck('telegram_chat_id')->all();

        $idAutorizzati = array_filter([$groupIdImpostazioni, ...$userIds]);

        $autorizzato = in_array($chatId, $idAutorizzati)
                    || in_array($userId, $idAutorizzati);

        if ($autorizzato) {
            $next($bot);
        }
    }
}
