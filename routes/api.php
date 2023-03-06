<?php

use App\Http\Controllers\BusController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\PathController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AuthController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Public routes
Route::post('/login', [AuthController::class, 'login']);
/* Route::post('/register/user', [AuthController::class, 'user']);
Route::post('/register/admin', [AuthController::class, 'user'])->middleware('auth:sanctum', 'role:admin'); */
Route::post('/register', [AuthController::class, 'register']);


// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::resource('/bus', BusController::class);
    Route::resource('/city', CityController::class);
    Route::resource('/path', PathController::class);
    Route::resource('/ticket', TicketController::class);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
