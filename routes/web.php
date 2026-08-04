<?php

use App\Http\Controllers\Admin\BlockedDateController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\TourController as AdminTourController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TourController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Site Público
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::view('/about', 'pages.about.index')
    ->name('about');

Route::get('/tours', [TourController::class, 'index'])
    ->name('tours');

Route::get('/tours/{tour}', [TourController::class, 'show'])
    ->name('tours.show');

Route::view('/gallery', 'pages.gallery.index')
    ->name('gallery');

Route::view('/contact', 'pages.contact.index')
    ->name('contact');

Route::view('/faq', 'pages.faq.index')
    ->name('faq');

/*
|--------------------------------------------------------------------------
| Idioma
|--------------------------------------------------------------------------
*/

Route::get('/language/{locale}', function (string $locale) {

    if (! in_array($locale, ['pt', 'en'])) {
        abort(404);
    }

    Session::put('locale', $locale);

    return redirect()->back();

})->name('language.switch');

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

        Route::resource('tours', AdminTourController::class);

        Route::post('tours/{tour}/move', [AdminTourController::class, 'move'])
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

    Route::delete('/profile', [ProfileController::class, 'destroy']);
});

require __DIR__.'/auth.php';