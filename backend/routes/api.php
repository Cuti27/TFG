<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DeviceController;
use App\Http\Controllers\API\HeadController;
use App\Http\Controllers\API\OutputInputController;
use App\Http\Controllers\API\ProgramController;
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
Route::get('/typeDevice', [DeviceController::class, 'getTypeDevice']);


// Auth routes
Route::group(['middleware' => ['auth:sanctum']], function () {

    // Logout sesion
    Route::post('/logout', [AuthController::class, 'logout']);

    // Create and get head

    Route::post('/head', [HeadController::class, 'createHead']);

    Route::get('/head/{id}', [HeadController::class, 'getHead']);

    Route::post('/head/{id}', [HeadController::class, 'updateHead']);

    Route::get('/head', [HeadController::class, 'getHeadByUser']);

    Route::delete('/head/{id}/delete', [HeadController::class, 'deleteHead']);

    // Create and add device

    Route::post("/head/{id}/device", [DeviceController::class, 'createDevice']);

    Route::get("/create/deviceId", [DeviceController::class, 'createIdDevice']);

    Route::get('/device', [DeviceController::class, 'listDevice']);

    Route::get('/device/{id}', [DeviceController::class, 'listDeviceHead']);

    Route::get('/deviceId', [DeviceController::class, 'listIdDevice']);

    Route::post('/device', [DeviceController::class, 'getDevice']);

    // Add and update OutputInput

    Route::post('/head/{id}/digitalOutput', [DeviceController::class, 'addDigitalOutput']);

    Route::post('/head/{id}/digitalInput', [DeviceController::class, 'addDigitalInput']);

    Route::post('/head/{id}/analogicalOutput', [DeviceController::class, 'addAnalogicalOutput']);

    Route::post('/head/{id}/analogicalInput', [DeviceController::class, 'addAnalogicalInput']);

    // List emitter and sector of head

    Route::get('/head/{id}/emitter', [DeviceController::class, 'getEmitterOfUser']);

    Route::get('/head/{id}/sector', [DeviceController::class, 'getSectorsOfUser']);


    // Crud program

    Route::post('/program', [ProgramController::class, 'createProgram']);

    Route::post('/program/delete', [ProgramController::class, 'deleteProgram']);

    Route::get('/head/{id}/program', [ProgramController::class, 'listProgram']);
});
