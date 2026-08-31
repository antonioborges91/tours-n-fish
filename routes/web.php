<?php

use App\Http\Controllers\Admin\BlockedPeriodController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\TourController as AdminTourController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController as PublicReservationController;
use App\Http\Controllers\TourController;
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

Route::post(
    '/reservation/{reservation:public_token}/payment-proof',
    [PublicReservationController::class, 'uploadPaymentProof']
)->name('reservations.payment-proof');

Route::post(
    '/reservation/{reservation:public_token}/cancel',
    [PublicReservationController::class, 'cancel']
)->name('reservations.cancel');


/*
|--------------------------------------------------------------------------
| Galeria
|--------------------------------------------------------------------------
*/

Route::get('/gallery', [GalleryController::class, 'index'])
    ->name('gallery');


/*
|--------------------------------------------------------------------------
| Contacto
|--------------------------------------------------------------------------
*/

Route::get('/contact', [ContactController::class, 'index'])
    ->name('contact');


/*
|--------------------------------------------------------------------------
| FAQ
|--------------------------------------------------------------------------
*/

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

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | Passeios
        |--------------------------------------------------------------------------
        */

        Route::resource('tours', AdminTourController::class);

        Route::post(
            'tours/{tour}/move',
            [AdminTourController::class, 'move']
        )->name('tours.move');


        /*
        |--------------------------------------------------------------------------
        | Galeria
        |--------------------------------------------------------------------------
        */

        Route::resource('gallery', AdminGalleryController::class);

        Route::post(
            'gallery/{gallery}/move',
            [AdminGalleryController::class, 'move']
        )->name('gallery.move');


        /*
        |--------------------------------------------------------------------------
        | Bloqueios
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'blocked-periods',
            BlockedPeriodController::class
        );


        /*
        |--------------------------------------------------------------------------
        | Reservas
        |--------------------------------------------------------------------------
        */

        // Ver comprovativo de pagamento
        Route::get(
            'reservations/{reservation}/payment-proof',
            [ReservationController::class, 'paymentProof']
        )->name('reservations.payment-proof');

        // Confirmar pagamento
        Route::post(
            'reservations/{reservation}/confirm-payment',
            [ReservationController::class, 'confirmPayment']
        )->name('reservations.confirm-payment');

        // Rejeitar comprovativo
        Route::post(
            'reservations/{reservation}/reject-payment',
            [ReservationController::class, 'rejectPayment']
        )->name('reservations.reject-payment');

        // Bloquear restante do dia
        Route::post(
            'reservations/{reservation}/block-remaining-day',
            [ReservationController::class, 'blockRemainingDay']
        )->name('reservations.block-remaining-day');

        // Cancelar reserva
        Route::post(
            'reservations/{reservation}/cancel',
            [ReservationController::class, 'cancel']
        )->name('reservations.cancel');

        // Eliminar definitivamente
        Route::delete(
            'reservations/{reservation}',
            [ReservationController::class, 'destroy']
        )->name('reservations.destroy');

        // Listagem e detalhe
        Route::resource(
            'reservations',
            ReservationController::class
        )->only(['index', 'show']);

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


/*
|--------------------------------------------------------------------------
| Autenticação
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';