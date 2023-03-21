<?php

use App\Http\Controllers\KadenaController;
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

Route::get('/kadenciya', function () {
    return view('kadenciya'); })->name('old.php');
    Route::get('/create', [KadenaController::class, 'create'])->name('kadena.create');
