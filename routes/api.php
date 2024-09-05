<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\vehicleController;
use App\Http\Controllers\driverController;
use App\Http\Controllers\ordersController;
use App\Http\Controllers\detailOrderController;
use App\Exports\OrdersExport;
use Maatwebsite\Excel\Facades\Excel;

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
        Route::get('getVehicleId/{id}', 'getVehicleId');
        Route::post('addVehicle', 'addVehicle');
        Route::patch('updateVehicle/{id}', 'updateVehicle');
        Route::patch('unassignVehicle/{id}', 'unassignVehicle');
        Route::delete('deleteVehicle/{id}', 'deleteVehicle');
    });

    Route::controller(driverController::class)->group(function () {
        Route::get('getDriver', 'getDriver');
        Route::get('getDriverId/{id}', 'getDriverId');
        Route::post('addDriver', 'addDriver');
        Route::patch('updateDriver/{id}', 'updateDriver');
        Route::patch('assignDriver/{id}', 'assignDriver');
        Route::patch('unassignDriver/{id}', 'unAssignDriver');
        Route::delete('deleteDriver/{id}', 'deleteDriver');
    });

    Route::controller(ordersController::class)->group(function () {
        Route::get('getOrder', 'getOrder');
        Route::get('getOrderId/{id}', 'getOrderId');
        Route::post('addOrder', 'addOrder');
        Route::patch('updateOrder/{id}', 'updateOrder');
        Route::patch('adminConsentApprove/{id}', 'adminConsentApprove');
        Route::patch('approverConsentApprove/{id}', 'approverConsentApprove');
        Route::patch('adminConsentDisapprove/{id}', 'adminConsentDisapprove');
        Route::patch('approverConsentDisapprove/{id}', 'approverConsentDisapprove');
        Route::delete('deleteOrder/{id}', 'deleteOrder');
        // Route::get('export-orders', 'exportOrdersToExcel');
    });

    Route::controller(detailOrderController::class)->group(function () {
        Route::get('getDetail', 'getDetail');
        Route::get('getDetailId/{id}', 'getDetailId');
        Route::get('getDetailIdOrder/{id}', 'getDetailIdOrder');
        Route::post('addDetail', 'addDetail');
        Route::patch('finishOrder/{id}', 'finishOrder');
    });

});
// Route::get('export-orders', [ordersController::class, 'exportOrdersToExcel']);

Route::get('export-orders', function () {
    return Excel::download(new OrdersExport, 'orders.xlsx');
});