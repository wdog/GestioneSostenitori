<?php

namespace App\Services;

use App\Models\User;
use App\Models\Adesione;
use App\Models\Sostenitore;
use App\Enums\StatoAdesione;
use App\Models\Impostazione;
use SergiX44\Nutgram\Nutgram;
use Illuminate\Support\Facades\Log;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

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

    protected function send(string $message, $parse_mode = ParseMode::HTML): void
    {
        if ( ! $this->isEnabled()) {
            return;
        }

        Log::debug('Telegram notification enabled!');

        $recipients = $this->getRecipients();

        if (empty($recipients)) {
            return;
        }

        Log::debug('Telegram notification with recipients: ' . implode(', ', $recipients));

        foreach ($recipients as $chatId) {
            try {
                $this->bot()->sendMessage(
                    text: $message,
                    chat_id: $chatId,
                    parse_mode: $parse_mode,
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
        $totaleSostenitori = Sostenitore::count();
        $data              = $sostenitore->created_at->format('d/m/Y H:i');

        $message = "🆕  <b>NUOVO SOSTENITORE</b>\n"
            . "\n"
            . "👤  <b>{$sostenitore->nome} {$sostenitore->cognome}</b>\n"
            . "\n"
            . "✉️  Email: {$sostenitore->email}\n"
            . "📅  Registrato il: {$data}\n"
            . "\n"
            . "┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄\n"
            . "\n"
            . "📊  Totale sostenitori: <b>{$totaleSostenitori}</b>\n"
            . "\n"
            . "🏛  <i>{$this->nomeAssociazione()}</i>\n";

        $this->send($message);
    }

    public function notifySostenitoreModificato(Sostenitore $sostenitore): void
    {
        $message = "✏️  <b>SOSTENITORE MODIFICATO</b>\n"
            . "\n"
            . "👤  <b>{$sostenitore->nome} {$sostenitore->cognome}</b>\n"
            . "\n"
            . "✉️  Email: {$sostenitore->email}\n"
            . "\n"
            . "-----\n"
            . "\n"
            . "🏛  <i>{$this->nomeAssociazione()}</i>\n";

        $this->send($message);
    }

    public function notifyNuovaAdesione(Adesione $adesione): void
    {
        $sostenitore  = $adesione->sostenitore;
        $livello      = $adesione->livello;
        $importo      = $adesione->importo_versato ? number_format($adesione->importo_versato, 2, ',', '.') . ' €' : 'Non specificato';
        $adesioniAnno = Adesione::where('anno', $adesione->anno)->count();

        $message = "🎉  <b>NUOVA ADESIONE</b>\n"
            . "\n"
            . "👤  <b>{$sostenitore->nome} {$sostenitore->cognome}</b>\n"
            . "✉️  {$sostenitore->email}\n"
            . "\n"
            . "🏅  Livello:  <b>{$livello->nome}</b>\n"
            . "📅  Anno:     <b>{$adesione->anno}</b>\n"
            . "💰  Importo:  <b>{$importo}</b>\n"
            . "🎫  Tessera:  <code>{$adesione->codice_tessera}</code>\n"
            . "📌  Stato:    {$adesione->stato->getLabel()}\n"
            . "\n"
            . "-----\n"
            . "\n"
            . "📊  Adesioni {$adesione->anno}: <b>{$adesioniAnno}</b>\n"
            . "\n"
            . "🏛  <i>{$this->nomeAssociazione()}</i>\n";

        $this->send($message);
    }

    public function notifyAdesioneModificata(Adesione $adesione): void
    {
        $sostenitore = $adesione->sostenitore;
        $livello     = $adesione->livello;
        $importo     = $adesione->importo_versato ? number_format($adesione->importo_versato, 2, ',', '.') . ' €' : 'Non specificato';

        $message = "✏️  <b>ADESIONE MODIFICATA</b>\n"
            . "\n"
            . "👤  <b>{$sostenitore->nome} {$sostenitore->cognome}</b>\n"
            . "\n"
            . "🏅  Livello:  <b>{$livello->nome}</b>\n"
            . "📅  Anno:     <b>{$adesione->anno}</b>\n"
            . "💰  Importo:  <b>{$importo}</b>\n"
            . "📌  Stato:    {$adesione->stato->getLabel()}\n"
            . "\n"
            . "-----\n"
            . "\n"
            . "🏛  <i>{$this->nomeAssociazione()}</i>\n";

        $this->send($message);
    }

    public function menu(int|string $chatId): void
    {
        $keyboard = InlineKeyboardMarkup::make()
            ->addRow(
                InlineKeyboardButton::make(
                    text: 'Numero Sostenitori',
                    callback_data: 'menu:summary_sostenitori'
                )
            )
            ->addRow(
                InlineKeyboardButton::make(
                    text: 'Numero Adesioni per anno',
                    callback_data: 'menu:summary_adesioni'
                )
            );

        $this->bot()->sendMessage(
            chat_id: $chatId,
            text: '📋 *Menu Report*',
            parse_mode: 'Markdown',
            reply_markup: $keyboard
        );
    }

    public function summarySostenitori(int|string $chatId): void
    {
        $count = Sostenitore::query()->count();
        Log::debug($count);
        $this->bot()->sendMessage(
            chat_id: $chatId,
            text: "📈 *Numero Sostenitori*\n\nTotale:\t*{$count}*",
            parse_mode: ParseMode::MARKDOWN
        );
    }

    public function summaryAdesioni(int|string $chatId): void
    {
        $rows = Adesione::query()
            ->selectRaw('anno, COUNT(*) as total')
            ->whereIn('stato', StatoAdesione::pagate())
            ->groupBy('anno')
            ->orderBy('anno', 'desc')
            ->pluck('total', 'anno');

        $text = "📈 *Adesioni per anno*\n\n";
        foreach ($rows as $anno => $total) {
            $text .= "🔸{$anno}:\t*{$total}*\n";
        }

        $this->bot()->sendMessage(
            chat_id: $chatId,
            text: $text,
            parse_mode: ParseMode::MARKDOWN
        );
    }
}
