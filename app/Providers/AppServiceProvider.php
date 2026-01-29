<?php

namespace App\Providers;

use App\Models\Adesione;
use App\Models\Sostenitore;
use App\Observers\AdesioneObserver;
use App\Observers\SostenitoreObserver;
use Illuminate\Database\Eloquent\Model;
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
    }
}
