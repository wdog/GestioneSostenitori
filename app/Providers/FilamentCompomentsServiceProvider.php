<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Blade;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\ServiceProvider;
use Filament\Resources\Pages\CreateRecord;

class FilamentCompomentsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Filament::serving(function () {
            Filament::registerRenderHook(
                PanelsRenderHook::BODY_START,
                fn(): string => Blade::render('@vite(["resources/js/app.js", "resources/css/app.css"])'),
            );
        });

        CreateRecord::disableCreateAnother();

        $this->registerTextColumnMacros();
    }

    protected function registerTextColumnMacros(): void
    {
        TextColumn::macro('moneyEUR', function (): TextColumn {
            /** @var TextColumn $this */
            return $this->formatStateUsing(
                fn($state): string => $state !== null
                    ? '€ ' . number_format((float) $state, 2, ',', '.')
                    : '—'
            );
        });
    }
}
