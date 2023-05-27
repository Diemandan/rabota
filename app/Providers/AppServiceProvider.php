<?php

namespace App\Providers;

use App\Models\Cadence;
use App\Repositories\CadenceRepository;
use App\Services\CadenceService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CadenceService::class, function ($app) {
            return new CadenceService(new CadenceRepository(new Cadence()));
        });

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
