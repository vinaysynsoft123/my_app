<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookingReport;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout',   [AuthController::class, 'logout'])->name('logout');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::patch('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::get('rooms', [RoomController::class, 'index'])->name('rooms.index');
    Route::get('rooms/create', [RoomController::class, 'create'])->name('rooms.create');
    Route::post('rooms', [RoomController::class, 'store'])->name('rooms.store');
    Route::get('rooms/{room}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
    Route::put('rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
    Route::delete('rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');

    Route::get('/booking-calendar', [BookingController::class, 'index'])->name('bookings.calendar');
    Route::get('/booking-events', [BookingController::class, 'events'])->name('bookings.events');    
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    
    Route::get('/rooms-by-date/{date}', [BookingController::class, 'roomsByDate'])->name('bookings.roomsByDate');
    Route::get('booking-report', [BookingReport::class, 'index'])->name('bookings.report');
    Route::get('bookings/{booking}', [BookingReport::class, 'show'])->name('bookings.show');

    Route::get('bookings/{booking}/download', [BookingReport::class, 'download'])->name('bookings.download');
    Route::post('bookings/{booking}/send-mail', [BookingReport::class, 'sendMail'])->name('bookings.sendMail');
    Route::post('bookings/{booking}/cancel', [BookingReport::class, 'cancel'])->name('bookings.cancel');

    //reprots
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

});

// Optional: redirect / to dashboard when logged in, login when guest
Route::get('/', function () {
    return redirect()->route(auth()->check() ? 'dashboard' : 'login');
});