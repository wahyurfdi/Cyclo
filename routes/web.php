<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebAppController;
use App\Http\Controllers\TrashTransactionController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('cms')->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::prefix('/trash/transaction')->group(function() {
        Route::get('/', [TrashTransactionController::class, 'index'])->name('trash.transaction');
        Route::put('/status', [TrashTransactionController::class, 'updateStatus']);
    });
});

Route::prefix('web-app')->group(function() {
    Route::get('/login', [WebAppController::class, 'index']);
    Route::get('/home', [WebAppController::class, 'index']);
    Route::get('/history', [WebAppController::class, 'index']);
    Route::get('/history/{code}', [WebAppController::class, 'index']);
    Route::get('/profile', [WebAppController::class, 'index']);
    Route::get('/request-pickup/trash-form', [WebAppController::class, 'index']);
    Route::get('/request-pickup/address-form', [WebAppController::class, 'index']);
    Route::get('/request-pickup/result', [WebAppController::class, 'index']);
});
