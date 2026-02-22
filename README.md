# Trasimeno Prog Levels

Gestionale per le adesioni annuali di un'associazione no-profit. Permette di gestire sostenitori, livelli di adesione, generazione di tessere PDF e notifiche via Telegram.

## Funzionalità

- **Sostenitori** — anagrafica con nome, cognome, email e numero di cellulare
- **Livelli di adesione** — livelli configurabili con importo suggerito (Base, Pro, Avanzato, Eterno)
- **Adesioni** — una per sostenitore per anno, con stati: attiva, pagamento pendente, scaduta, annullata
- **Tessere PDF** — generazione e invio via email di tessere personalizzate per livello
- **Notifiche Telegram** — notifiche automatiche su nuovi sostenitori e modifiche
- **Bot Telegram** — menu interattivo con report, ricerca sostenitori e accesso ristretto tramite chat ID
- **Log attività** — tracciamento di login, creazioni, modifiche e invii tessera con dati old/new in JSON
- **Pannello admin** — interfaccia FilamentPHP con impostazioni associazione, logo e configurazione Telegram

## Stack tecnico

| Layer | Tecnologia |
|---|---|
| Backend | PHP 8.4, Laravel 12 |
| Admin UI | FilamentPHP v5, Livewire 4 |
| Frontend | Tailwind CSS v4 |
| Database | MySQL 8.0 |
| Bot Telegram | Nutgram |

## Configurazione `.env`

```env
APP_NAME="Trasimeno Prog Levels"
APP_ENV=local

DB_CONNECTION=mysql
DB_HOST=...
DB_DATABASE=...

TELEGRAM_TOKEN=...
TELEGRAM_BOT_USERNAME=nome_del_bot

MAIL_MAILER=smtp
MAIL_FROM_ADDRESS=noreply@example.com
```

## Bot Telegram

Il bot espone un menu interattivo (`/menu`) con:

- **Report** — statistiche adesioni dell'anno corrente per stato e livello
- **Cerca sostenitore** — ricerca per nome, cognome o email
- **Chat ID** — mostra l'ID della chat per configurare le notifiche

L'accesso al menu è ristretto ai chat ID configurati nel pannello admin (utenti singoli o gruppi Telegram).

## Struttura principale

```
app/
├── Filament/
│   ├── Actions/          # InviaTesseraAction
│   ├── Pages/            # Impostazioni
│   └── Resources/        # Sostenitori, Adesioni, Livelli, ActivityLog
├── Models/               # Sostenitore, Adesione, Livello, ActivityLog, Impostazione
├── Observers/            # SostenitoreObserver
├── Services/             # TesseraPdfService, ActivityLogService
├── Telegram/
│   ├── Commands/         # StartCommand
│   ├── Menus/            # MainMenu
│   └── Middleware/       # AuthorizeChat
└── Mail/                 # TesseraInviata
```
