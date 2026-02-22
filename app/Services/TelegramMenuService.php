<?php

namespace App\Services;

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

class TelegramMenuService
{
    /**
     * Menu tree definition.
     *
     * Each menu entry:
     *   'title' => string  - header text (HTML)
     *   'items' => array   - list of buttons, each with:
     *     'label' => string  - button text
     *     'data'  => string  - callback_data in format "type:value"
     *       - "show:menuKey"   → navigate to another menu
     *       - "action:name"    → execute an action
     *
     * @var array<string, array{title: string, items: array<array{label: string, data: string}>}>
     */
    protected array $menus = [
        'main' => [
            'title' => '📋 <b>Menu Principale</b>',
            'items' => [
                ['label' => '📊 Report', 'data' => 'show:reports'],
            ],
        ],
        'reports' => [
            'title' => '📊 <b>Report</b>',
            'items' => [
                ['label' => '👥 Numero Sostenitori',      'data' => 'action:summary_sostenitori'],
                ['label' => '📅 Adesioni per anno',       'data' => 'action:summary_adesioni'],
                ['label' => '⬅️ Indietro',                'data' => 'show:main'],
            ],
        ],
    ];

    public function show(Nutgram $bot, int|string $chatId, string $menuKey = 'main'): void
    {
        $menu = $this->menus[$menuKey] ?? $this->menus['main'];

        $keyboard = InlineKeyboardMarkup::make();

        foreach ($menu['items'] as $item) {
            $keyboard->addRow(
                InlineKeyboardButton::make(
                    text: $item['label'],
                    callback_data: $item['data'],
                )
            );
        }

        $bot->sendMessage(
            chat_id: $chatId,
            text: $menu['title'],
            parse_mode: 'HTML',
            reply_markup: $keyboard,
        );
    }

    public function handleCallback(Nutgram $bot): void
    {
        $chatId = $bot->chat()->id;
        $data   = $bot->callbackQuery()->data ?? '';

        [$type, $value] = array_pad(explode(':', $data, 2), 2, '');

        match ($type) {
            'show'   => $this->show($bot, $chatId, $value),
            'action' => $this->executeAction($bot, $chatId, $value),
            default  => null,
        };
    }

    protected function executeAction(Nutgram $bot, int|string $chatId, string $action): void
    {
        $service = app(TelegramNotificationService::class);

        match ($action) {
            'summary_sostenitori' => $service->summarySostenitori($chatId),
            'summary_adesioni'    => $service->summaryAdesioni($chatId),
            default               => null,
        };
    }
}
