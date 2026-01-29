<?php

namespace App\Services;

use App\Models\User;
use App\Models\Adesione;
use App\Models\Sostenitore;
use App\Models\Impostazione;
use SergiX44\Nutgram\Nutgram;
use Illuminate\Support\Facades\Log;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;

class TelegramNotificationService
{
    protected function bot(): Nutgram
    {
        return app(Nutgram::class);
    }

    public function isEnabled(): bool
    {
        return (bool) Impostazione::get('telegram_notifications_enabled', false);
    }

    /**
     * @return array<string>
     */
    protected function getRecipients(): array
    {
        $recipients = [];

        $groupChatId = Impostazione::get('telegram_group_chat_id');
        if ($groupChatId) {
            $recipients[] = $groupChatId;
        }

        $userChatIds = User::query()
            ->whereNotNull('telegram_chat_id')
            ->where('telegram_chat_id', '!=', '')
            ->where('telegram_notifications_enabled', true)
            ->pluck('telegram_chat_id')
            ->all();

        return array_unique(array_merge($recipients, $userChatIds));
    }

    protected function send(string $message): void
    {
        if ( ! $this->isEnabled()) {
            return;
        }

        $recipients = $this->getRecipients();

        if (empty($recipients)) {
            return;
        }

        foreach ($recipients as $chatId) {
            try {
                $this->bot()->sendMessage(
                    text: $message,
                    chat_id: $chatId,
                    parse_mode: ParseMode::HTML,
                );
            } catch (\Throwable $e) {
                Log::warning("Telegram notification failed for chat {$chatId}: {$e->getMessage()}");
            }
        }
    }

    protected function nomeAssociazione(): string
    {
        return Impostazione::getNomeAssociazione();
    }

    public function notifyNuovoSostenitore(Sostenitore $sostenitore): void
    {
        $totaleAdesioni = Sostenitore::count();

        $message = "🆕 <b>Nuovo Sostenitore</b>\n"
            . "━━━━━━━━━━━━━━━━━━\n"
            . "👤 <b>{$sostenitore->nome} {$sostenitore->cognome}</b>\n"
            . "✉️ {$sostenitore->email}\n"
            . '📅 Registrato il: ' . $sostenitore->created_at->format('d/m/Y H:i') . "\n"
            . "━━━━━━━━━━━━━━━━━━\n"
            . "📊 Totale sostenitori: <b>{$totaleAdesioni}</b>\n"
            . "🏛 {$this->nomeAssociazione()}";

        $this->send($message);
    }

    public function notifySostenitoreModificato(Sostenitore $sostenitore): void
    {
        $dirty           = $sostenitore->getChanges();
        $campiModificati = collect($dirty)
            ->except(['updated_at'])
            ->keys()
            ->map(fn (string $campo) => match ($campo) {
                'nome'    => '📝 Nome',
                'cognome' => '📝 Cognome',
                'email'   => '✉️ Email',
                default   => $campo,
            })
            ->implode(', ');

        $message = "✏️ <b>Sostenitore Modificato</b>\n"
            . "━━━━━━━━━━━━━━━━━━\n"
            . "👤 <b>{$sostenitore->nome} {$sostenitore->cognome}</b>\n"
            . "✉️ {$sostenitore->email}\n"
            . "🔄 Campi modificati: {$campiModificati}\n"
            . "━━━━━━━━━━━━━━━━━━\n"
            . "🏛 {$this->nomeAssociazione()}";

        $this->send($message);
    }

    public function notifyNuovaAdesione(Adesione $adesione): void
    {
        $sostenitore  = $adesione->sostenitore;
        $livello      = $adesione->livello;
        $importo      = $adesione->importo_versato ? number_format($adesione->importo_versato, 2, ',', '.') . ' €' : 'Non specificato';
        $adesioniAnno = Adesione::where('anno', $adesione->anno)->count();

        $message = "🎉 <b>Nuova Adesione</b>\n"
            . "━━━━━━━━━━━━━━━━━━\n"
            . "👤 <b>{$sostenitore->nome} {$sostenitore->cognome}</b>\n"
            . "✉️ {$sostenitore->email}\n"
            . "━━━━━━━━━━━━━━━━━━\n"
            . "🏅 Livello: <b>{$livello->nome}</b>\n"
            . "📅 Anno: <b>{$adesione->anno}</b>\n"
            . "💰 Importo: <b>{$importo}</b>\n"
            . "🎫 Tessera: <code>{$adesione->codice_tessera}</code>\n"
            . "📌 Stato: {$adesione->stato->getLabel()}\n"
            . "━━━━━━━━━━━━━━━━━━\n"
            . "📊 Adesioni {$adesione->anno}: <b>{$adesioniAnno}</b>\n"
            . "🏛 {$this->nomeAssociazione()}";

        $this->send($message);
    }

    public function notifyAdesioneModificata(Adesione $adesione): void
    {
        $sostenitore = $adesione->sostenitore;
        $livello     = $adesione->livello;
        $importo     = $adesione->importo_versato ? number_format($adesione->importo_versato, 2, ',', '.') . ' €' : 'Non specificato';

        $dirty           = $adesione->getChanges();
        $campiModificati = collect($dirty)
            ->except(['updated_at'])
            ->keys()
            ->map(fn (string $campo) => match ($campo) {
                'livello_id'      => '🏅 Livello',
                'stato'           => '📌 Stato',
                'importo_versato' => '💰 Importo',
                'tessera_path'    => '🎫 Tessera',
                'codice_tessera'  => '🎫 Codice tessera',
                default           => $campo,
            })
            ->implode(', ');

        $message = "✏️ <b>Adesione Modificata</b>\n"
            . "━━━━━━━━━━━━━━━━━━\n"
            . "👤 <b>{$sostenitore->nome} {$sostenitore->cognome}</b>\n"
            . "━━━━━━━━━━━━━━━━━━\n"
            . "🏅 Livello: <b>{$livello->nome}</b>\n"
            . "📅 Anno: <b>{$adesione->anno}</b>\n"
            . "💰 Importo: <b>{$importo}</b>\n"
            . "📌 Stato: {$adesione->stato->getLabel()}\n"
            . "🔄 Modifiche: {$campiModificati}\n"
            . "━━━━━━━━━━━━━━━━━━\n"
            . "🏛 {$this->nomeAssociazione()}";

        $this->send($message);
    }
}
