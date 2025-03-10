<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\CompanyProfileController;
use App\Http\Controllers\Admin\Controller as AdminController;
use App\Http\Controllers\Admin\EventsController as AdminEventsController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [HomeController::class, 'index']);

Route::controller(EventsController::class)->group(function () {
    Route::match(['get', 'post'], '/event', 'index')->name('event.index'); 
    Route::get('/event/{id}', 'show')->name('event.show');
    // Route::post('/event', 'store'); 
    // Route::put('/event/{id}', 'update'); 
    // Route::delete('/event/{id}', 'destroy'); 
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    Route::get('/dashboard/company/edit/{company_profile}', [CompanyProfileController::class, 'edit'])->name('dashboard.company.edit');
    Route::put('/dashboard/company/update/{company_profile}', [CompanyProfileController::class, 'update'])->name('dashboard.company.update');

    Route::get('/dashboard/event', [AdminEventsController::class, 'index'])->name('dashboard.event.index');
    Route::get('/dashboard/event/edit/{event}', [AdminEventsController::class, 'edit'])->name('dashboard.event.edit');
    Route::put('/dashboard/event/update/{event}', [AdminEventsController::class, 'update'])->name('dashboard.event.update');

    Route::get('/dashboard/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/dashboard/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/dashboard/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';