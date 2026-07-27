<?php

use App\Http\Controllers\Admin\BlockedDateController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\TourController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Site Público
|--------------------------------------------------------------------------
*/

Route::view('/', 'pages.home.index')
    ->name('home');

Route::view('/about', 'pages.about.index')
    ->name('about');

Route::view('/tours', 'pages.tours.index')
    ->name('tours');

Route::view('/gallery', 'pages.gallery.index')
    ->name('gallery');

Route::view('/contact', 'pages.contact.index')
    ->name('contact');

Route::view('/faq', 'pages.faq.index')
    ->name('faq');

/*
|--------------------------------------------------------------------------
| Administração
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('tours', TourController::class);

        Route::post('tours/{tour}/move', [TourController::class, 'move'])
            ->name('tours.move');

        Route::resource('gallery', GalleryController::class);

        Route::resource('blocked-dates', BlockedDateController::class);

        Route::resource('reservations', ReservationController::class)
            ->only(['index', 'show', 'update']);
    });

/*
|--------------------------------------------------------------------------
| Perfil
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__ . '/auth.php';