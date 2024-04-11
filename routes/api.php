<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DriverController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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



// get user and token
Route::post('/sanctum/token', [ApiController::class, 'store']);
Route::middleware('auth:sanctum')->post('/verify-otp-code', [ApiController::class, 'otpCode']);

// New API route to post driver data
Route::middleware('auth:sanctum')->post('/save-driver', [DriverController::class, 'driverSave']);
Route::middleware('auth:sanctum')->post('/verify/user', [ApiController::class, 'verifyUser']);


Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/user/revoke', function (Request $request) {
    // return $request->user();
    $user = $request->user();
    $user->tokens()->delete();
    return 'tokens are deleted';
});

// Login
// Route::middleware('auth:sanctum')->post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->get('/logout', [AuthController::class, 'logoutt']);


// New API route to post driver data
// Route::middleware('auth:sanctum')->post('/save-driver', [DriverController::class, 'driverSave']);
// Route::middleware('auth:sanctum')->get('/drivers', [DriverController::class, 'getDrivers']);
