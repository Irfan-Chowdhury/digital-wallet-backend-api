<?php

use App\Http\Controllers\API\AgentController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\WalletController;
use Illuminate\Support\Facades\Route;

// Route::controller(AuthController::class)->group(function () {
//     Route::post('register', 'register');
//     Route::post('login', 'login');
// });

Route::prefix('v1')->group(function () {


    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->middleware('auth:sanctum');
    Route::get('/agent/dashboard', [UserController::class, 'AgentDashboard'])->middleware('auth:sanctum'); // new


    Route::get('/user/all-users', [UserController::class, 'index'])->middleware('auth:sanctum', 'role:ADMIN');
    Route::patch('/user/{id}/status', [UserController::class, 'statusChange'])->middleware('auth:sanctum', 'role:ADMIN');


    Route::get('/user/profile', [UserController::class, 'profile'])->middleware('auth:sanctum'); //new
    Route::put('/user/profile', [UserController::class, 'profileUpdate'])->middleware('auth:sanctum'); //new



    Route::get('/agents', [AgentController::class, 'getAllAgents'])->middleware('auth:sanctum', 'role:ADMIN');
    Route::patch('/agents/{id}/status', [AgentController::class, 'statusChange'])->middleware('auth:sanctum', 'role:ADMIN'); //depricated



    Route::post('/user/register', [UserController::class, 'register']);


    Route::prefix('wallet')->group( function () {
        //User
        Route::patch('/add-money', [WalletController::class, 'addMoney'])->middleware('auth:sanctum');
        Route::patch('/withdraw-money', [WalletController::class, 'withdrawMoney'])->middleware('auth:sanctum');
        Route::post('/send-money', [WalletController::class, 'sendMoney'])->middleware('auth:sanctum');

        // Agent
        Route::post('/cash-in', [WalletController::class, 'cashIn'])->middleware('auth:sanctum');
        Route::post('/cash-out', [WalletController::class, 'cashOut'])->middleware('auth:sanctum');

    });

    Route::prefix('transaction')->group( function () {
        Route::get('/my-transactions', [TransactionController::class, 'userOrAgentTransactionHistory'])->middleware('auth:sanctum');
    });




    Route::controller(AuthController::class)->group(function () {
        Route::post('/auth/login', 'login');
        Route::post('/auth/logout', 'logout')->middleware('auth:sanctum');
    });
});


// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('/logout', [AuthController::class, 'logout']);

//     Route::middleware(['role:admin'])->group(function () {
//         Route::prefix('services')->group(function () {
//             Route::controller(ServiceController::class)->group(function () {
//                 Route::post('/', 'store');
//                 Route::put('/{id}', 'update');
//                 Route::delete('/{id}', 'destroy');
//             });
//         });
//         Route::get('/admin/bookings', [BookingController::class, 'getAllBookingsByAdmin']);
//     });

//     Route::middleware(['role:customer'])->group(function () {
//         Route::get('/services', [ServiceController::class, 'index']);
//         Route::prefix('bookings')->group(function () {
//             Route::get('/', [BookingController::class, 'getAllBookingsByCustomer']);
//             Route::post('/', [BookingController::class, 'store']);
//         });
//     });

// });
