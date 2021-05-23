<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\OutputInputController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Login and register routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Get info of TypeOutputInput

Route::get('/analogicalInput', [OutputInputController::class, 'getAnalogicalInput']);
Route::get('/analogicalOutput', [OutputInputController::class, 'getAnalogicalOutput']);
Route::get('/digitalInput', [OutputInputController::class, 'getDigitalInput']);
Route::get('/digitalOutput', [OutputInputController::class, 'getDigitalOutput']);


// Auth routes
Route::group(['middleware' => ['auth:sanctum']], function () {

    // Logout sesion
    Route::post('/logout', [AuthController::class, 'logout']);
});
