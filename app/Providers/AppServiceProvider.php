<?php

namespace App\Providers;

use App\Models\Cadence;
use App\Models\Salary;
use App\Repositories\CadenceRepository;
use App\Repositories\SalaryRepository;
use App\Services\CadenceService;
use App\Services\SalaryService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        $this->app->bind(SalaryService::class, function ($app) {
            return new SalaryService(new SalaryRepository(new Salary()));
        });

        $this->app->bind(CadenceService::class, function ($app) {
            return new CadenceService(
                new CadenceRepository(new Cadence()),
                $app->make(SalaryService::class));
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
