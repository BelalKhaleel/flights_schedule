<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\PassengerController;
use App\Http\Controllers\UserController;
use App\Models\Flight;
use App\Models\Passenger;
use Illuminate\Support\Facades\Auth;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::group(['middleware' => ['auth:sanctum', 'role:Admin']], function () {
    Route::resources([
        'users' => UserController::class,
        'passengers' => PassengerController::class,
        'flights' => FlightController::class,
    ]);
});

Route::middleware('role:Passenger')->group(function () {
    Route::get('api/flights', [FlightController::class, 'index']);
    Route::get('api/flights/{id}', [FlightController::class, 'show']);

    Route::get('api/passengers', [PassengerController::class, 'index']);
    Route::get('api/passengers/{id}', [PassengerController::class, 'show']);
    Route::post('api/passengers', [PassengerController::class, 'store']);
    Route::post('api/passengers/{id}', [PassengerController::class, 'update']);
    Route::delete('api/passengers/{id}', [PassengerController::class, 'destroy']);
});
// Route::resource('passengers', PassengerController::class)->only('store');

// Route::controller(AuthController::class)->group(function () {
//     Route::post('/auth/logout', 'destroy')->middleware('auth:sanctum');
//     Route::post('/admin/login', 'loginAdmin');
// });

// Route::group(['middleware' => ['role:Admin']], function () {
//     Route::resources([
//         'users' => UserController::class,
//         'passengers' => PassengerController::class,
//         'flights' => FlightController::class,
//     ]);
// });
