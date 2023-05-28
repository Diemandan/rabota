<?php

namespace App\Providers;

use App\Models\Bonus;
use App\Models\Cadence;
use App\Models\Expense;
use App\Models\Salary;
use App\Repositories\BonusRepository;
use App\Repositories\CadenceRepository;
use App\Repositories\ExpenseRepository;
use App\Repositories\SalaryRepository;
use App\Services\BonusService;
use App\Services\CadenceService;
use App\Services\ExpenseService;
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

        $this->app->bind(ExpenseService::class, function ($app) {
            return new ExpenseService(new ExpenseRepository(new Expense()));
        });

        $this->app->bind(BonusService::class, function ($app) {
            return new BonusService(new BonusRepository(new Bonus()));
        });

        $this->app->bind(CadenceService::class, function ($app) {
            return new CadenceService(
                new CadenceRepository(new Cadence()),
                $app->make(SalaryService::class),
                $app->make(BonusService::class),
                $app->make(ExpenseService::class),
            );
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
