<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AgentAuthController;
use App\Http\Controllers\Api\CustomerApiController;
use App\Http\Controllers\Api\BranchApiController;
use App\Http\Controllers\Api\GoldItemApiController;

use App\Http\Controllers\Api\BankApiController;


// API v1 Routes
Route::prefix('v1')->group(function () {
    // Agent Login API
    Route::post('/agent/login', [AgentAuthController::class, 'login']);
    // this is customers api

    Route::get('customers', [CustomerApiController::class, 'index']);
    Route::post('customers', [CustomerApiController::class, 'store']);
    Route::get('customers/{id}', [CustomerApiController::class, 'show']);
    Route::put('customers/{id}', [CustomerApiController::class, 'update']);
    Route::delete('customers/{id}', [CustomerApiController::class, 'destroy']);

    // this is banks api
    Route::get('banks', [BankApiController::class, 'index']);
    Route::post('banks', [BankApiController::class, 'store']);
    Route::get('banks/{id}', [BankApiController::class, 'show']);
    Route::put('banks/{id}', [BankApiController::class, 'update']);
    Route::delete('banks/{id}', [BankApiController::class, 'destroy']);
    // this is branch 
    Route::get('branches', [BranchApiController::class, 'index']);
    Route::post('branches', [BranchApiController::class, 'store']);
    Route::get('branches/{id}', [BranchApiController::class, 'show']);
    Route::put('branches/{id}', [BranchApiController::class, 'update']);
    Route::delete('branches/{id}', [BranchApiController::class, 'destroy']);
    // this is gold item
    Route::get('gold-items', [GoldItemApiController::class, 'index']);
    Route::post('gold-items', [GoldItemApiController::class, 'store']);
    Route::get('gold-items/{id}', [GoldItemApiController::class, 'show']);
    Route::put('gold-items/{id}', [GoldItemApiController::class, 'update']);
    Route::delete('gold-items/{id}', [GoldItemApiController::class, 'destroy']);
});
