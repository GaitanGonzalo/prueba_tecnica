<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
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

Route::post('/login', [AuthController::class, 'login'])->name('api.login');
Route::middleware('atoken')->group(function(){
    Route::get('/customers', [CustomerController::class, 'index'])->name('api.customer.index');
    Route::post('/customers', [CustomerController::class, 'store'])->name('api.customer.store');
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('api.customer.del');
});
