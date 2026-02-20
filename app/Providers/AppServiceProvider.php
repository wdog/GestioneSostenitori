<?php

namespace App\Providers;

use App\Models\Adesione;
use App\Models\Sostenitore;
use Filament\Support\Assets\Js;
use App\Observers\AdesioneObserver;
use Illuminate\Support\Facades\Vite;
use App\Observers\SostenitoreObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentAsset;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::automaticallyEagerLoadRelationships();

        Sostenitore::observe(SostenitoreObserver::class);
        Adesione::observe(AdesioneObserver::class);

        FilamentAsset::register([
            Js::make('chart-js-plugins', Vite::asset('resources/js/filament-chart-js-plugins.js'))->module(),
        ]);
    }
}
