<?php

namespace App\Telegram\Menus;

use App\Models\Adesione;
use App\Models\Sostenitore;
use App\Enums\StatoAdesione;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Conversations\InlineMenu;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;

/**
 * Menu principale del bot Telegram.
 *
 * Espone le funzionalità di reportistica, ricerca sostenitori
 * e recupero del chat ID per la configurazione delle notifiche.
 */
class MainMenu extends InlineMenu
{
    protected string $command = 'menu';

    protected ?string $description = 'Apri il menu principale';

    /**
     * Mostra il menu principale con le azioni disponibili.
     */
    public function start(Nutgram $bot): void
    {
        $this->clearButtons()
            ->menuText('Menu Principale')
            ->addButtonRow(
                InlineKeyboardButton::make('☰ Report', callback_data: 'report@handleReport'),
                InlineKeyboardButton::make('🔍 Cerca sostenitore', callback_data: 'cerca@handleCerca'),
                InlineKeyboardButton::make('🔑 Chat Id', callback_data: 'get-id@handleGetId'),
            )
            ->showMenu();
    }

    /**
     * Mostra il chat ID dell'utente corrente,
     * utile per configurare le notifiche nel pannello admin.
     */
    public function handleGetId(Nutgram $bot): void
    {
        $chatId = $bot->message()->chat()->id;

        $this->clearButtons()
            ->menuText("Il tuo chat ID è:\n\n<code>{$chatId}</code>\n\nUsalo per configurare le notifiche nel pannello admin.", ['parse_mode' => ParseMode::HTML])
            ->addButtonRow(
                $this->indietroButton(),
            )
            ->showMenu();
    }

    /**
     * Genera e mostra un report statistico sulle adesioni dell'anno corrente:
     * totale sostenitori, adesioni attive/pendenti/scadute e breakdown per livello.
     */
    public function handleReport(Nutgram $bot): void
    {
        $anno = now()->year;

        $totaleSostenitori = Sostenitore::count();

        $adesioniAnno = Adesione::where('anno', $anno)->get();
        $totaleAnno   = $adesioniAnno->count();
        $attive       = $adesioniAnno->where('stato', StatoAdesione::Attiva)->count();
        $pendenti     = $adesioniAnno->where('stato', StatoAdesione::PagamentoPendente)->count();
        $scadute      = $adesioniAnno->whereIn('stato', [StatoAdesione::Scaduta, StatoAdesione::Annullata])->count();

        $perLivello = Adesione::where('anno', $anno)
            ->join('livelli', 'adesioni.livello_id', '=', 'livelli.id')
            ->selectRaw('livelli.nome, COUNT(*) as totale')
            ->groupBy('livelli.id', 'livelli.nome')
            ->orderBy('livelli.nome')
            ->pluck('totale', 'nome');

        $text = "<b>Report</b>\n\n";
        $text .= "Sostenitori totali: <b>{$totaleSostenitori}</b>\n\n";
        $text .= "Adesioni {$anno}: <b>{$totaleAnno}</b>\n";
        $text .= "  Attive: {$attive}\n";
        $text .= "  Da incassare: {$pendenti}\n";
        $text .= "  Scadute / Annullate: {$scadute}\n";

        if ($perLivello->isNotEmpty()) {
            $text .= "\nPer livello:\n";
            foreach ($perLivello as $nome => $totale) {
                $text .= "  {$nome}: {$totale}\n";
            }
        }

        $this->clearButtons()
            ->menuText($text, ['parse_mode' => ParseMode::HTML])
            ->addButtonRow(
                $this->indietroButton(),
            )
            ->showMenu();
    }

    /**
     * Avvia il flusso di ricerca sostenitore,
     * mettendo la conversazione in ascolto del messaggio successivo.
     */
    public function handleCerca(Nutgram $bot): void
    {
        $this->clearButtons()
            ->menuText("Cerca sostenitore\n\nInviami nel prossimo messaggio una parte del nome, cognome o dell'email:")
            ->addButtonRow(
                $this->indietroButton(),
            )
            ->orNext('handleSearch')
            ->showMenu();
    }

    /**
     * Esegue la ricerca per nome, cognome o email.
     * Mostra al massimo 5 risultati; se ne trova più di 5 invita a raffinare la ricerca.
     */
    public function handleSearch(Nutgram $bot): void
    {
        $query = trim($bot->message()->text ?? '');

        if (strlen($query) < 2) {
            $this->clearButtons()
                ->menuText("Cerca sostenitore\n\nInserisci almeno 2 caratteri:")
                ->addButtonRow(
                    $this->indietroButton(),
                )
                ->orNext('handleSearch')
                ->showMenu();

            return;
        }

        $results = Sostenitore::query()
            ->where(function ($q) use ($query) {
                $q->where('nome', 'like', "%{$query}%")
                    ->orWhere('cognome', 'like', "%{$query}%")
                    ->orWhere('email', 'like', "%{$query}%");
            })
            ->with(['adesioni' => fn ($q) => $q->orderByDesc('anno')->with('livello')])
            ->limit(6)
            ->get();

        $total = $results->count();
        $shown = $results->take(5);

        if ($total === 0) {
            $text = "Nessun risultato per «{$query}»";
        } else {
            $suffix = $total > 5
                ? ' — trovati molti, mostro i primi 5. Affina la ricerca.'
                : " ({$total})";

            $text = "<b>Risultati per «{$query}»</b>{$suffix}\n\n";

            foreach ($shown as $sostenitore) {
                $text .= "<b>{$sostenitore->nome} {$sostenitore->cognome}</b>\n";
                $text .= "  {$sostenitore->email}";

                if ($sostenitore->mobile) {
                    $text .= " - {$sostenitore->mobile}";
                }

                $text .= "\n";

                $adesione = $sostenitore->adesioni->first();

                if ($adesione) {
                    $text .= "  {$adesione->livello->nome} - {$adesione->anno} - {$adesione->stato->getLabel()}\n";
                }

                $text .= "\n";
            }
        }

        $this->clearButtons()
            ->menuText($text, ['parse_mode' => ParseMode::HTML])
            ->addButtonRow(
                InlineKeyboardButton::make('↺ Nuova ricerca', callback_data: 'new@handleCerca'),
                $this->indietroButton(),
            )
            ->showMenu();
    }

    /**
     * Bottone condiviso per tornare al menu principale.
     */
    private function indietroButton(): InlineKeyboardButton
    {
        return InlineKeyboardButton::make('← Indietro', callback_data: 'back@start');
    }
}
