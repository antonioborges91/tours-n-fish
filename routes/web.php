<?php

use App\Http\Controllers\Admin\BlockedPeriodController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\TourController as AdminTourController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ReservationController as PublicReservationController;
use Illuminate\Support\Facades\Route;
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


/*
|--------------------------------------------------------------------------
| Reservas - Área Pública
|--------------------------------------------------------------------------
*/

Route::post(
    '/reservations',
    [PublicReservationController::class, 'store']
)->name('reservations.store');


Route::get(
    '/reservation/{reservation:public_token}',
    [PublicReservationController::class, 'show']
)->name('reservations.show');


Route::get('/gallery', [GalleryController::class, 'index'])
    ->name('gallery');


Route::get('/contact', [ContactController::class, 'index'])
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


        Route::resource('gallery', AdminGalleryController::class);


        Route::post('gallery/{gallery}/move', [AdminGalleryController::class, 'move'])
            ->name('gallery.move');


        Route::resource('blocked-periods', BlockedPeriodController::class);


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