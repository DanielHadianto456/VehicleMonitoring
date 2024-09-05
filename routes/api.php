<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\vehicleController;
use App\Http\Controllers\driverController;
use App\Http\Controllers\ordersController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(AuthController::class)->group(function () {
    Route::post('registerApprover', 'registerApprover');
    Route::post('registerAdmin', 'registerAdmin');
    Route::post('login', 'login');
    Route::get('getUser', 'getUser');
});

Route::middleware('auth:userModel')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::controller(AuthController::class)->group(function () {
        Route::post('logout', 'logout');
        Route::get('getAllUser', 'getAllUser');
    });
    Route::controller(vehicleController::class)->group(function () {
        Route::get('getVehicle', 'getVehicle');
        Route::post('addVehicle', 'addVehicle');
        Route::patch('updateVehicle/{id}', 'updateVehicle');
        Route::patch('unassignVehicle/{id}', 'unassignVehicle');
        Route::delete('deleteVehicle/{id}', 'deleteVehicle');
    });
    Route::controller(driverController::class)->group(function () {
        Route::get('getDriver', 'getDriver');
        Route::post('addDriver', 'addDriver');
        Route::patch('updateDriver/{id}', 'updateDriver');
        Route::patch('assignDriver/{id}', 'assignDriver');
        Route::patch('unassignDriver/{id}', 'unAssignDriver');
        Route::delete('deleteDriver/{id}', 'deleteDriver');
    });
    Route::controller(ordersController::class)->group(function () {
        Route::get('getOrder', 'getOrder');
        Route::post('addOrder', 'addOrder');
        Route::patch('updateOrder/{id}', 'updateOrder');
        Route::patch('adminConsentApprove/{id}', 'adminConsentApprove');
        Route::patch('approverConsentApprove/{id}', 'approverConsentApprove');
        Route::patch('adminConsentDisapprove/{id}', 'adminConsentDisapprove');
        Route::patch('approverConsentDisapprove/{id}', 'approverConsentDisapprove');
        Route::delete('deleteOrder/{id}', 'deleteOrder');
    });
});