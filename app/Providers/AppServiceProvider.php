<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Fatura;
use App\Models\Siparis;
use App\Observers\FaturaObserver;
use App\Observers\SiparisObserver;

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
        // Observer'ları kaydet
        Fatura::observe(FaturaObserver::class);
        Siparis::observe(SiparisObserver::class);
    }
}
