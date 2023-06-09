<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\WebAppController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [WebAppController::class, 'login']);
Route::get('/profile', [WebAppController::class, 'getProfile']);
Route::prefix('trash')->group(function() {
    Route::post('/transaction/create', [WebAppController::class, 'createTrashTransaction']);
    Route::post('/transaction/cancel', [WebAppController::class, 'cancelTrashTransaction']);
    Route::get('/transaction/list', [WebAppController::class, 'getTrashTransactionList']);
    Route::get('/transaction/detail', [WebAppController::class, 'getTrashTransactionDetail']);
});