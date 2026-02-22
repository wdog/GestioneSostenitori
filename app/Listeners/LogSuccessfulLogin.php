<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Auth\Events\Login;
use App\Services\ActivityLogService;
use Illuminate\Support\Facades\Auth;

/**
 * Registra nel log ogni accesso riuscito al pannello admin,
 * salvando IP e user agent del browser.
 */
class LogSuccessfulLogin
{
    public function handle(Login $event): void
    {
        // dd($event);
        ActivityLogService::log(
            event: 'login',
            subject: Auth::user(),
        );
    }
}
