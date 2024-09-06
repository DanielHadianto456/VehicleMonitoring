<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ordersController;
use App\Http\Controllers\detailOrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/vehicle', function () {
    return view('vehicle');
})->name('vehicle');

Route::get('/reservation', function () {
    return view('reservation');
})->name('reservation');

Route::post('/reservation', function () {
    return view('reservation');
})->name('reservation');

Route::get('/approvals', function () {
    return view('approvals');
})->name('approvals');

Route::get('/detailItem/{id}', function ($id) {
    return view('detailItem', ['id' => $id]);
})->name('detailItem');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/addOrder', [ordersController::class, 'addOrder'])->name('order.create');
// Route::patch('/adminConsentApprove/{id}', [])

Route::controller(ordersController::class)->group(function () {
    Route::get('getOrder', 'getOrder');
    Route::get('getOrderId/{id}', 'getOrderId');
    // Route::post('addOrder', 'addOrder');
    Route::patch('updateOrder/{id}', 'updateOrder');
    Route::patch('adminConsentApprove/{id}', 'adminConsentApprove')->name('admin.approve');
    Route::patch('approverConsentApprove/{id}', 'approverConsentApprove')->name('approver.aprrove');
    Route::patch('adminConsentDisapprove/{id}', 'adminConsentDisapprove')->name('admin.disapprove');
    Route::patch('approverConsentDisapprove/{id}', 'approverConsentDisapprove')->name('approver.disapprove');
    Route::delete('deleteOrder/{id}', 'deleteOrder');
    // Route::get('export-orders', 'exportOrdersToExcel');
});

Route::controller(detailOrderController::class)->group(function () {
    Route::get('getDetail', 'getDetail');
    Route::get('getDetailId/{id}', 'getDetailId');
    Route::get('getDetailIdOrder/{id}', 'getDetailIdOrder');
    Route::post('addDetail', 'addDetail')->name('add.detail');
    Route::patch('finishOrder/{id}', 'finishOrder');
});

require __DIR__.'/auth.php';
