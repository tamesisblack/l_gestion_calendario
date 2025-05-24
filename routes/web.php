<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\CordinadorAreaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReservationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('usuarios', UserController::class);

Route::get('/reservations/pagos',[ReservationController::class,'showPayments'])->name('reservations.pagos');

Route::get('/reservations/calendario',function(){
    return view('reservations.calendario');
})->name('reservations.calendario');

Route::get('administrador/fullcalendar',[ReservationController::class,'getAllReservations'])->name('administrador.fullcalendar');

Route::resource('reservations', ReservationController::class);
Route::post('reservation.cancel',[ReservationController::class,'cancel'])->name('reservations.cancel');

Route::get('/asesor/calendario',function(){
    return view('asesor.calendario');
})->name('asesor.calendario');

Route::get('asesor/fullcalendar',[ReservationController::class,'getReservationsAsesor'])->name('asesor.fullcalendar');

Route::get('/cliente/pagos',[ReservationController::class,'showClientPayments'])->name('cliente.pagos');

Route::get('/cliente/calendario',function(){
    return view('cliente.calendario');
})->name('cliente.calendario');

Route::get('cliente/fullcalendar',[ReservationController::class,'getReservationsCliente'])->name('cliente.fullcalendar');

Route::get('cliente/reservas',[ReservationController::class,'indexcliente'])->name('cliente.reservas');
Route::get('cliente/reserva',[ReservationController::class,'createCliente'])->name('cliente.reserva');

Route::post('/paypal',[ReservationController::class,'completePayment']);

Route::get('welcome/fullcalendar',[ReservationController::class,'getAllReservationsLanding'])->name('welcome.fullcalendar');

Route::get('/reservations/{id}', [ReservationController::class, 'show']);

Route::get('/reservations/evidencias/{iduser}/{fecha}', [ReservationController::class, 'reservationEvidences'])->name('reservations.evidencias');
require __DIR__.'/auth.php';

Route::resource('areas', AreaController::class);
Route::resource('cordinadores', CordinadorAreaController::class);
Route::get('/areas/{area}/cordinadores', [AreaController::class, 'getCordinadores'])->name('areas.cordinadores');


