<?php

use App\Http\Controllers\CadenceController;
use App\Http\Controllers\SalaryController;
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

Route::get('/salary', [SalaryController::class, 'index'])->name('salary.index');
Route::get('/salary/create', [SalaryController::class, 'create'])->name('salary.create');
Route::post('/salary/create', [SalaryController::class, 'store'])->name('salary.store');

Route::get('/kadenciya', function () {
    return view('kadenciya');
})->name('home');

Route::get('/cadence/index', [CadenceController::class, 'index'])->name('cadences.index');
Route::get('/cadence/create', [CadenceController::class, 'create'])->name('cadence.create');
Route::get('/cadence/create/{id}', [CadenceController::class, 'edit'])->name('cadence.edit');
Route::get('/cadence/show/{id}', [CadenceController::class, 'show'])->name('cadence.show');
Route::post('/cadence/create', [CadenceController::class, 'store'])->name('cadence.store');
Route::delete('/cadence/{id}/delete', [CadenceController::class, 'delete'])->name('cadence.delete');
