<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\ParkingController;
use App\Http\Controllers\ServicesController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('dashboard');
// });


Route::get('/', function () {
    return view('auth.login');
});

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/', [AuthController::class, 'login'])->name('login');



Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/verifyotp', [DashboardController::class, 'showVerfy']);
    Route::post('/post-otp', [AuthController::class, 'otpsubmit'])->name('otpsubmit');


    Route::prefix('location')->group(function () {
        Route::get('/getRegionDistrict/{id}', [ServicesController::class, 'getRegionDistrict']);
        Route::get('/getDistrictWard/{id}', [ServicesController::class, 'getDistrictWard']);

        // Route::get('/country', [ServicesController::class, 'country']);
        // Route::get('/country_view', [ServicesController::class, 'country_view']);
        // Route::post('/saveCountry', [ServicesController::class, 'saveCountry']);
        // Route::get('/editCountry/{id}', [ServicesController::class, 'editCountry']);
        // Route::get('/deleteCountry/{id}', [ServicesController::class, 'deleteCountry']);

        Route::get('/region', [ServicesController::class, 'region']);
        Route::get('/region_view', [ServicesController::class, 'region_view']);
        Route::post('/saveRegion', [ServicesController::class, 'saveRegion']);
        Route::get('/editRegion/{id}', [ServicesController::class, 'editRegion']);
        Route::get('/deleteRegion/{id}', [ServicesController::class, 'deleteRegion']);

        Route::get('/district', [ServicesController::class, 'district']);
        Route::get('/district_view', [ServicesController::class, 'district_view']);
        Route::post('/saveDistrict', [ServicesController::class, 'saveDistrict']);
        Route::get('/editDistrict/{id}', [ServicesController::class, 'editDistrict']);
        Route::get('/deleteDistrict/{id}', [ServicesController::class, 'deleteDistrict']);

        Route::get('/ward', [ServicesController::class, 'ward']);
        Route::get('/ward_view', [ServicesController::class, 'ward_view']);
        Route::post('/saveWard', [ServicesController::class, 'saveWard']);
        Route::get('/editWard/{id}', [ServicesController::class, 'editWard']);
        Route::get('/deleteWard/{id}', [ServicesController::class, 'deleteWard']);


        // Route::get('/village', [ServicesController::class, 'village']);
        // Route::get('/village_view', [ServicesController::class, 'village_view']);
        // Route::post('/saveVillage', [ServicesController::class, 'saveVillage']);
        // Route::get('/editVillage/{id}', [ServicesController::class, 'editVillage']);
        // Route::get('/deleteVillage/{id}', [ServicesController::class, 'deleteVillage']);
    });

    Route::prefix('driver')->group(function () {
        Route::get('/driver', [DriverController::class, 'driver']);
        Route::get('/driver_view', [DriverController::class, 'driver_view']);
        Route::post('/driverSave', [DriverController::class, 'driverSave']);
        Route::get('/editDriver/{id}', [DriverController::class, 'editDriver']);
        Route::get('/viewDiver/{id}', [DriverController::class, 'viewDiver']);
        Route::get('/deleteDriver/{id}', [DriverController::class, 'deleteDriver']);
    });

    Route::prefix('parking')->group(function () {
        Route::get('/parking', [ParkingController::class, 'parking']);
        Route::get('/parking_view', [ParkingController::class, 'parking_view']);
        Route::post('/saveParking', [ParkingController::class, 'saveParking']);
        Route::get('/editParking/{id}', [ParkingController::class, 'editParking']);
        Route::get('/viewParking/{id}', [ParkingController::class, 'viewParking']);
        Route::get('/deleteParking/{id}', [ParkingController::class, 'deleteParking']);
    });
});
