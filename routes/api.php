<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BonusController;
use App\Http\Controllers\API\BudgetController;
use App\Http\Controllers\API\CadenceController;
use App\Http\Controllers\API\ExpenseController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\SalaryController;
use App\Http\Controllers\API\StatisticController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Публичные маршруты
Route::post('auth/login', [AuthController::class, 'login']);

// Платежи (публичные)
Route::post('callback', [PaymentController::class, 'saveSuccessPaymentInfo']);
Route::post('callback/failed', [PaymentController::class, 'saveFailedPaymentInfo']);

// Защищенные маршруты
Route::middleware('auth:sanctum')->group(function () {
    // Авторизация
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::get('auth/user', [AuthController::class, 'user']);

    // Каденции
    Route::apiResource('cadences', CadenceController::class);

    // Зарплаты
    Route::apiResource('salaries', SalaryController::class);

    // Расходы
    Route::apiResource('expenses', ExpenseController::class);

    // Бонусы
    Route::apiResource('bonuses', BonusController::class);

    // Бюджет
    Route::apiResource('budgets', BudgetController::class);

    // Статистика
    Route::get('statistics', [StatisticController::class, 'index']);
});
