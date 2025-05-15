<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StakeholderController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\DisplayController;

Auth::routes();
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/stakeholders', [StakeholderController::class, 'index'])->name('stakeholders');

Route::get('/newStakeholder', [StakeholderController::class, 'create'])->name('newStakeholder');
Route::post('/newStakeholder', [StakeholderController::class, 'store']);
Route::get('/details/{stakeholderId}', [StakeholderController::class, 'show'])->name('details');
Route::get('/editStakeholder/{stakeholderId}', [StakeholderController::class, 'edit'])->name('editStakeholder');
Route::post('/editStakeholder/{stakeholderId}', [StakeholderController::class, 'update']);
Route::get('/deleteStakeholder/{stakeholderId}', [StakeholderController::class, 'destroy'])->name('deleteStakeholder');


Route::get('/newTransaction/{stakeholderId}', [TransactionController::class, 'create'])->name('newTransaction');
Route::post('/newTransaction/{stakeholderId}', [TransactionController::class, 'store']);
Route::get('/editTransaction/{transactionId}', [TransactionController::class, 'edit'])->name('editTransaction');
Route::post('/editTransaction/{transactionId}', [TransactionController::class, 'update']);
Route::get('/deleteTransaction/{transactionId}', [TransactionController::class, 'destroy'])->name('deleteTransaction');
Route::get('/deleteTransactions/{stakeholderId}', [TransactionController::class, 'destroyTransactions'])->name('deleteTransactions');



Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
Route::get('/readNotification/{notificationId}', [NotificationController::class, 'read'])->name('readNotification');


Route::get('display1', [DisplayController::class, 'display1'])->name('display1');
Route::get('display2', [DisplayController::class, 'display2'])->name('display2');
Route::get('display3', [DisplayController::class, 'display3'])->name('display3');
