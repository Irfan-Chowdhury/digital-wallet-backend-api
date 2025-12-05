<?php

use App\Http\Controllers\API\AgentController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\API\TransactionController;
// use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\WalletController;
use App\Http\Controllers\TravelPlanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Client\DestinationController;
use App\Http\Controllers\Client\TravelerController;


// Route::prefix('v1')->group(function () {

//     Route::controller(AuthController::class)->group(function () {
//         Route::post('/auth/login', 'login');
//         Route::post('/auth/logout', 'logout')->middleware('auth:sanctum');
//     });


//     Route::middleware('auth:sanctum')->group(function () {
//         Route::prefix('admin')->group( function () {
//             Route::get('/dashboard', [UserController::class, 'AdminDashboard']); // new
//             Route::get('/transactions', [TransactionController::class, 'adminTransaction']); // new
//             Route::get('/listings', [TransactionController::class, 'adminListing']); // new
//         });
//     });

//     Route::prefix('user')->group( function () {
//         Route::post('/register', [UserController::class, 'register']);

//         Route::middleware('auth:sanctum')->group(function () {
//             Route::get('/dashboard', [UserController::class, 'dashboard']);
//             Route::get('/all-users', [UserController::class, 'index'])->middleware('role:ADMIN');
//             Route::patch('/{id}/status', [UserController::class, 'statusChange'])->middleware('role:ADMIN');
//             Route::get('/profile', [UserController::class, 'profile']); //new
//             Route::put('/profile', [UserController::class, 'profileUpdate']); //new
//         });
//     });

//     Route::prefix('agent')->group( function () {
//         Route::get('/dashboard', [UserController::class, 'AgentDashboard'])->middleware('auth:sanctum'); // new

//     });

//     // Route::get('/user/all-users', [UserController::class, 'index'])->middleware('auth:sanctum', 'role:ADMIN');
//     // Route::patch('/user/{id}/status', [UserController::class, 'statusChange'])->middleware('auth:sanctum', 'role:ADMIN');
//     // Route::get('/user/profile', [UserController::class, 'profile'])->middleware('auth:sanctum'); //new
//     // Route::put('/user/profile', [UserController::class, 'profileUpdate'])->middleware('auth:sanctum'); //new


//     Route::get('/agents', [AgentController::class, 'getAllAgents'])->middleware('auth:sanctum', 'role:ADMIN');
//     Route::patch('/agents/{id}/status', [AgentController::class, 'statusChange'])->middleware('auth:sanctum', 'role:ADMIN'); //deprecated


//     Route::middleware('auth:sanctum')->group(function () {
//         Route::prefix('wallet')->group( function () {
//             //User
//             Route::patch('/add-money', [WalletController::class, 'addMoney'])->middleware('auth:sanctum');
//             Route::patch('/withdraw-money', [WalletController::class, 'withdrawMoney'])->middleware('auth:sanctum');
//             Route::post('/send-money', [WalletController::class, 'sendMoney'])->middleware('auth:sanctum');
//             // Agent
//             Route::post('/cash-in', [WalletController::class, 'cashIn'])->middleware('auth:sanctum');
//             Route::post('/cash-out', [WalletController::class, 'cashOut'])->middleware('auth:sanctum');
//         });
//     });

//     Route::prefix('transaction')->group( function () {
//         Route::get('/my-transactions', [TransactionController::class, 'userOrAgentTransactionHistory'])->middleware('auth:sanctum');
//     });


// });






    /*
    |--------------------------------------------------------------------------
    | AUTH
    |--------------------------------------------------------------------------
    */
    // Route::prefix('auth')->group(function () {
    //     Route::post('register', [AuthController::class, 'register']);
    //     Route::post('login',    [AuthController::class, 'login']);

    //     Route::middleware('auth:sanctum')->group(function () {
    //         Route::post('logout', [AuthController::class, 'logout']);
    //         Route::get('me',      [AuthController::class, 'me']);
    //     });
    // });


     /*
    |--------------------------------------------------------------------------
    | PUBLIC RESOURCES
    |--------------------------------------------------------------------------
    */
    Route::get('destinations/popular', [DestinationController::class, 'popular']);
    Route::get('travelers/top-rated', [TravelerController::class, 'topRated']);


    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);


    Route::apiResource('travel-plans', TravelPlanController::class);


    // Route::get('interests', [InterestController::class, 'index']);
    // Route::get('users',     [UserController::class, 'index']);
    // Route::get('users/{id}',[UserController::class, 'show']);

    // Route::get('plans',               [TravelPlanController::class, 'index']);
    // Route::get('plans/{id}',          [TravelPlanController::class, 'show']);
    // Route::get('search/travelers',    [SearchController::class, 'travelers']);
    // Route::get('search/plans',        [SearchController::class, 'plans']);
    // Route::get('search/match/{uid}',  [SearchController::class, 'match']);


    /*
    |--------------------------------------------------------------------------
    | AUTHENTICATED ROUTES
    |--------------------------------------------------------------------------
    */
    // Route::middleware('auth:sanctum')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | USERS
        |--------------------------------------------------------------------------
        */
        // Route::put('users/{id}',      [UserController::class, 'update']);
        // Route::delete('users/{id}',   [UserController::class, 'destroy']);

        // Profiles
        // Route::get('profiles/{uid}',  [UserProfileController::class, 'show']);
        // Route::put('profiles/{uid}',  [UserProfileController::class, 'update']);

        // User Interests
        // Route::get('users/{id}/interests', [UserInterestController::class, 'userInterests']);
        // Route::post('users/{id}/interests',[UserInterestController::class, 'store']);
        // Route::delete('users/{id}/interests/{int}',
        //     [UserInterestController::class, 'destroy']
        // );


        /*
        |--------------------------------------------------------------------------
        | TRAVEL PLANS
        |--------------------------------------------------------------------------
        */
        // Route::post('plans',          [TravelPlanController::class, 'store']);
        // Route::put('plans/{id}',      [TravelPlanController::class, 'update']);
        // Route::delete('plans/{id}',   [TravelPlanController::class, 'destroy']);

        // // Plan interests
        // Route::get('plans/{id}/interests',
        //     [PlanInterestController::class, 'index']
        // );
        // Route::post('plans/{id}/interests',
        //     [PlanInterestController::class, 'store']
        // );
        // Route::delete('plans/{id}/interests/{interest_id}',
        //     [PlanInterestController::class, 'destroy']
        // );


        /*
        |--------------------------------------------------------------------------
        | PARTICIPANTS
        |--------------------------------------------------------------------------
        */
        // Route::get('plans/{id}/participants',
        //     [ParticipantController::class, 'index']
        // );
        // Route::post('plans/{id}/participants',
        //     [ParticipantController::class, 'store']
        // );
        // Route::put('plans/{id}/participants/{uid}',
        //     [ParticipantController::class, 'update']
        // );
        // Route::delete('plans/{id}/participants/{uid}',
        //     [ParticipantController::class, 'destroy']
        // );


        /*
        |--------------------------------------------------------------------------
        | JOIN REQUESTS
        |--------------------------------------------------------------------------
        */
        // Route::post('plans/{id}/join',
        //     [JoinRequestController::class, 'store']
        // );

        // Route::get('plans/{id}/join-requests',
        //     [JoinRequestController::class, 'planRequests']
        // );

        // Route::put('join-requests/{req_id}/approve',
        //     [JoinRequestController::class, 'approve']
        // );

        // Route::put('join-requests/{req_id}/reject',
        //     [JoinRequestController::class, 'reject']
        // );

        // Route::delete('join-requests/{req_id}',
        //     [JoinRequestController::class, 'destroy']
        // );


        /*
        |--------------------------------------------------------------------------
        | REVIEWS
        |--------------------------------------------------------------------------
        */
        // Route::get('users/{id}/reviews',
        //     [ReviewController::class, 'userReviews']
        // );
        // Route::post('reviews',        [ReviewController::class, 'store']);
        // Route::get('reviews/{id}',    [ReviewController::class, 'show']);
        // Route::put('reviews/{id}',    [ReviewController::class, 'update']);
        // Route::delete('reviews/{id}', [ReviewController::class, 'destroy']);


        /*
        |--------------------------------------------------------------------------
        | NOTIFICATIONS
        |--------------------------------------------------------------------------
        */
        // Route::get('notifications',      [NotificationController::class, 'index']);
        // Route::put('notifications/{id}/read',
        //     [NotificationController::class, 'markRead']
        // );
        // Route::delete('notifications/{id}',
        //     [NotificationController::class, 'destroy']
        // );


        /*
        |--------------------------------------------------------------------------
        | BOOKINGS & PAYMENTS
        |--------------------------------------------------------------------------
        */
        // Bookings
        // Route::post('plans/{id}/book',         [BookingController::class, 'store']);
        // Route::get('plans/{id}/bookings',      [BookingController::class, 'planBookings']);
        // Route::get('bookings/{id}',            [BookingController::class, 'show']);
        // Route::put('bookings/{id}',            [BookingController::class, 'update']);
        // Route::delete('bookings/{id}',         [BookingController::class, 'destroy']);

        // // Payments
        // Route::post('payments/initiate',       [PaymentController::class, 'initiate']);
        // Route::post('payments/confirm',        [PaymentController::class, 'confirm']);
        // Route::get('payments/{id}',            [PaymentController::class, 'show']);
        // Route::get('users/{id}/payments',      [PaymentController::class, 'userPayments']);
    // });


    /*
    |--------------------------------------------------------------------------
    | PAYMENT WEBHOOK (No Auth)
    |--------------------------------------------------------------------------
    */
    // Route::post('v1/payments/webhook', [PaymentWebhookController::class, 'handle']);


    /*
    |--------------------------------------------------------------------------
    | USER DASHBOARD (auth)
    |--------------------------------------------------------------------------
    */
    // Route::middleware('auth:sanctum')->group(function () {
    //     Route::prefix('dashboard')->group(function () {
    //         Route::get('overview',       [DashboardController::class, 'overview']);
    //         Route::get('trips',          [DashboardController::class, 'trips']);
    //         Route::get('matches',        [DashboardController::class, 'matches']);
    //         Route::get('notifications',  [DashboardController::class, 'notifications']);
    //         Route::get('payments',       [DashboardController::class, 'payments']);
    //     });
    // });


    /*
    |--------------------------------------------------------------------------
    | ADMIN PANEL (Admin Middleware)
    |--------------------------------------------------------------------------
    */
    // Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {

    //     // Users
    //     Route::get('users',                [AdminUserController::class, 'index']);
    //     Route::put('users/{id}/ban',       [AdminUserController::class, 'ban']);
    //     Route::put('users/{id}/unban',     [AdminUserController::class, 'unban']);

    //     // Plans
    //     Route::get('plans',                [AdminPlanController::class, 'index']);
    //     Route::put('plans/{id}/approve',   [AdminPlanController::class, 'approve']);
    //     Route::put('plans/{id}/reject',    [AdminPlanController::class, 'reject']);
    //     Route::delete('plans/{id}',        [AdminPlanController::class, 'destroy']);

    //     // Reviews
    //     Route::get('reviews',              [AdminReviewController::class, 'index']);
    //     Route::delete('reviews/{id}',      [AdminReviewController::class, 'destroy']);

    //     // Stats
    //     Route::get('stats',                [AdminStatsController::class, 'stats']);
    // });
