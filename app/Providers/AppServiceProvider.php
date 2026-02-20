<?php

namespace App\Providers;

use App\Models\Adesione;
use App\Models\Sostenitore;
use App\Observers\AdesioneObserver;
use App\Observers\SostenitoreObserver;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

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
