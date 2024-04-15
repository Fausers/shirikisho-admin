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

// Route::middleware('cors')->group(function () {
    Route::post('/sanctum/token', [ApiController::class, 'store']);
    Route::middleware('auth:sanctum')->group(function () {

        // get user and token

        Route::post('/verify-otp-code', [ApiController::class, 'otpCode']);

        // New API route to post driver data
        Route::post('/verify/user', [ApiController::class, 'verifyUser']);
        Route::post('/save-driver', [DriverController::class, 'driverSave']);
        Route::post('/update-driver/{id}', [DriverController::class, 'updateDrive']);

        // Location
        Route::get('/region', [ApiController::class, 'getRegion']);
        Route::get('/region/{id}/district', [ApiController::class, 'regionDistrict']);
        Route::get('/district/{id}/ward', [ApiController::class, 'districtWard']);

        // Parking
        Route::post('/get-parking/{regionId}/{districtId}/{wardId}',[ApiController::class,'getParking']);




        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        Route::get('/user/revoke', function (Request $request) {
            // return $request->user();
            $user = $request->user();
            $user->tokens()->delete();
            return 'tokens are deleted';
        });

        // Login
        // Route::middleware('auth:sanctum')->post('/login', [AuthController::class, 'login']);
        Route::get('/logout', [AuthController::class, 'logoutt']);


        // New API route to post driver data
        // Route::middleware('auth:sanctum')->post('/save-driver', [DriverController::class, 'driverSave']);
        // Route::get('/drivers', [DriverController::class, 'getDrivers']);
    });
// });
