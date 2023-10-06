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

Route::middleware('role:Editor')->group(function () {
    Route::get('api/flights', [FlightController::class, 'index']);
    Route::get('api/flights/{id}', [FlightController::class, 'show']);

    Route::get('api/passengers', [PassengerController::class, 'index']);
    Route::get('api/passengers/{id}', [PassengerController::class, 'show']);
    Route::post('api/passengers', [PassengerController::class, 'store']);
    Route::post('api/passengers/{id}', [PassengerController::class, 'update']);
    Route::delete('api/passengers/{id}', [PassengerController::class, 'destroy']);
});

