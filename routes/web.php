<?php

use Illuminate\Support\Facades\Route;

// **Controllers Public**
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProspectController;

// **Controllers Admin**
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProspectController as AdminProspectController;
use App\Http\Controllers\Admin\VideoController;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/prospects', [ProspectController::class, 'store'])->name('prospects.store');

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('prospects', Admin\ProspectController::class);
    Route::resource('videos', Admin\VideoController::class);
});

