<?php

use App\Models\Impostazione;
use App\Models\User;
use App\Telegram\Middleware\AuthorizeChat;
use Illuminate\Foundation\Testing\RefreshDatabase;
use SergiX44\Nutgram\Nutgram;

uses(RefreshDatabase::class);

function fakeBot(int $chatId, int $userId): Nutgram
{
    $bot = Mockery::mock(Nutgram::class);
    $bot->shouldReceive('chatId')->andReturn($chatId);
    $bot->shouldReceive('userId')->andReturn($userId);
    return $bot;
}

test('autorizza utente con telegram_chat_id configurato', function () {
    User::factory()->create(['telegram_chat_id' => '111']);

    $called = false;
    $next   = function () use (&$called) { $called = true; };

    (new AuthorizeChat())(fakeBot(chatId: 111, userId: 111), $next);

    expect($called)->toBeTrue();
});

test('autorizza gruppo configurato nelle impostazioni', function () {
    Impostazione::set('telegram_group_chat_id', '-100999');

    $called = false;
    $next   = function () use (&$called) { $called = true; };

    (new AuthorizeChat())(fakeBot(chatId: -100999, userId: 222), $next);

    expect($called)->toBeTrue();
});

test('blocca chat non autorizzata', function () {
    $called = false;
    $next   = function () use (&$called) { $called = true; };

    (new AuthorizeChat())(fakeBot(chatId: 999, userId: 999), $next);

    expect($called)->toBeFalse();
});
