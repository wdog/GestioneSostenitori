<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\TelegramNotificationService;

class SendTelegramNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @param  string  $method  The method name on TelegramNotificationService
     * @param  array<int, mixed>  $args  The arguments to pass to the method
     */
    public function __construct(
        public string $method,
        public array $args,
    ) {}

    public function handle(TelegramNotificationService $service): void
    {
        $service->{$this->method}(...$this->args);
    }
}
