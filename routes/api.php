<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API v1 Routes
|--------------------------------------------------------------------------
*/

// Controllers
use App\Http\Controllers\Api\AgentAuthController;
use App\Http\Controllers\Api\CustomerApiController;
use App\Http\Controllers\Api\BankApiController;
use App\Http\Controllers\Api\BranchApiController;
use App\Http\Controllers\Api\GoldItemApiController;
use App\Http\Controllers\Api\SlotBookingApiController;

use App\Http\Controllers\Api\SecondGoldItemApiController;
use App\Http\Controllers\Api\GoldPriceApiController;
use App\Http\Controllers\Api\AgentSMSApiController;
use App\Http\Controllers\Api\DashboardApiController;

Route::prefix('v1')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | AGENT LOGIN
    |--------------------------------------------------------------------------
    */
    Route::post('agent/login', [AgentAuthController::class, 'login']);



    /*
    |--------------------------------------------------------------------------
    | CUSTOMERS API
    |--------------------------------------------------------------------------
    */
    Route::controller(CustomerApiController::class)->group(function () {
        Route::get('customers', 'index');
        Route::post('customers', 'store');
        Route::get('customers/{id}', 'show');
        Route::put('customers/{id}', 'update');
        Route::delete('customers/{id}', 'destroy');
    });



    /*
    |--------------------------------------------------------------------------
    | BANKS API
    |--------------------------------------------------------------------------
    */
    Route::controller(BankApiController::class)->group(function () {
        Route::get('banks', 'index');
        Route::post('banks', 'store');
        Route::get('banks/{id}', 'show');
        Route::put('banks/{id}', 'update');
        Route::delete('banks/{id}', 'destroy');
    });



    /*
    |--------------------------------------------------------------------------
    | BRANCHES API
    |--------------------------------------------------------------------------
    */
    Route::controller(BranchApiController::class)->group(function () {
        Route::get('branches', 'index');
        Route::post('branches', 'store');
        Route::get('branches/{id}', 'show');
        Route::put('branches/{id}', 'update');
        Route::delete('branches/{id}', 'destroy');
    });



    /*
    |--------------------------------------------------------------------------
    | GOLD ITEMS API (First Appraisal)
    |--------------------------------------------------------------------------
    */
    Route::controller(GoldItemApiController::class)->group(function () {
        Route::get('gold-items', 'index');
        Route::post('gold-items', 'store');
        Route::get('gold-items/{id}', 'show');
        Route::put('gold-items/{id}', 'update');
        Route::delete('gold-items/{id}', 'destroy');
    });



    /*
    |--------------------------------------------------------------------------
    | SECOND GOLD ITEMS API
    |--------------------------------------------------------------------------
    */
    Route::controller(SecondGoldItemApiController::class)->group(function () {
        Route::get('second-gold-items', 'index');
        Route::get('second-gold-items/folios', 'folios');
        Route::post('second-gold-items', 'store');
        Route::get('second-gold-items/{id}', 'show');
        Route::post('second-gold-items/{id}', 'update'); // Using POST for update
        Route::delete('second-gold-items/{id}', 'destroy');
    });


/*
|--------------------------------------------------------------------------
| SLOT BOOKING API
|--------------------------------------------------------------------------
*/

Route::controller(SlotBookingApiController::class)->group(function () {
    Route::get('slot-bookings', 'index');      // List All
    Route::post('slot-bookings', 'store');     // Create
    Route::get('slot-bookings/{id}', 'show');  // Single
    Route::put('slot-bookings/{id}', 'update'); // Update
    Route::delete('slot-bookings/{id}', 'destroy'); // Delete
});

    /*
    |--------------------------------------------------------------------------
    | GOLD PRICE API
    |--------------------------------------------------------------------------
    */
    Route::get('gold-price/latest', [GoldPriceApiController::class, 'latest']);



    /*
    |--------------------------------------------------------------------------
    | SMS LOG LIST API
    |--------------------------------------------------------------------------
    */
     Route::post('sms/send', [AgentSMSApiController::class, 'send']);

    // Agent Get SMS
    Route::get('sms/agent', [AgentSMSApiController::class, 'agentMessages']);

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD SUMMARY API
    |--------------------------------------------------------------------------
    */
    Route::get('dashboard', [DashboardApiController::class, 'index']);
});
