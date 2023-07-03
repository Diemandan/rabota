<?php

use App\Http\Controllers\BonusController;
use App\Http\Controllers\CadenceController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\StatisticController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/kadenciya', function () {
    return view('kadenciya');
})->name('home');

Route::get('/salaries/index', [SalaryController::class, 'index'])->name('salaries.index');
Route::get('/salary/create', [SalaryController::class, 'create'])->name('salary.create');
Route::post('/salary/create', [SalaryController::class, 'store'])->name('salary.store');
Route::delete('/salary/{id}/delete', [SalaryController::class, 'delete'])->name('salary.delete');

Route::get('/expenses/index', [ExpenseController::class, 'index'])->name('expenses.index');
Route::get('/expense/create', [ExpenseController::class, 'create'])->name('expense.create');
Route::post('/expenses/create', [ExpenseController::class, 'store'])->name('expense.store');
Route::delete('/expense/{id}/delete', [ExpenseController::class, 'delete'])->name('expense.delete');

Route::get('/bonuses/index', [BonusController::class, 'index'])->name('bonuses.index');
Route::get('/bonus/create', [BonusController::class, 'create'])->name('bonus.create');
Route::post('/bonus/create', [BonusController::class, 'store'])->name('bonus.store');
Route::delete('/bonus/{id}/delete', [BonusController::class, 'delete'])->name('bonus.delete');

Route::get('/cadences/index', [CadenceController::class, 'index'])->name('cadences.index');
Route::get('/cadence/create', [CadenceController::class, 'create'])->name('cadence.create');
Route::get('/cadence/create/{id}', [CadenceController::class, 'edit'])->name('cadence.edit');
Route::get('/cadence/show/{id}', [CadenceController::class, 'show'])->name('cadence.show');
Route::post('/cadence/create', [CadenceController::class, 'store'])->name('cadence.store');
Route::delete('/cadence/{id}/delete', [CadenceController::class, 'delete'])->name('cadence.delete');

Route::get('/statistics/index', [StatisticController::class, 'index'])->name('statistics.index');

Route::get('/statistics', function () {
    return view('statistics/statistic');
})->name('statistic');
