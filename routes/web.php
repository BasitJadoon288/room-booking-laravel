

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomBookingController;

// Show booking form + table of bookings
Route::get('/', [RoomBookingController::class, 'index'])->name('booking.index');

// Handle form submission via API
Route::post('/roombooking-submit', [RoomBookingController::class, 'submit'])->name('booking.submit');

