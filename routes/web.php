<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Eventos\EventoSocialesController;
use App\Http\Controllers\Fotografia\FotosController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Auth;

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
    return view('auth.login');
});

Auth::routes();


Route::group(['middleware' => ['auth', 'can:Organizador']], function () {
    // Rutas Autenticadas que solo pueden ser accedidas por usuarios con el rol "Organizador"
    Route::get('abrir_creareventos', [EventoSocialesController::class, 'abrir_creareventos'])->name('abrir_creareventos');
    Route::post('registrar_evento', [EventoSocialesController::class, 'registrar_evento'])->name('registrar_evento');
    Route::get('abrir_alleventos', [EventoSocialesController::class, 'abrir_alleventos'])->name('abrir_alleventos');
    Route::delete('/eventos/{id}', [EventoSocialesController::class, 'eliminarEvento'])->name('eliminarEvento');
    Route::get('/getevento/{id}', [EventoSocialesController::class, 'getevento'])->name('getevento');



    Route::get('abrir_registrarinvitado/{id_evento}', [EventoSocialesController::class, 'abrir_registrarinvitado'])->name('abrir_registrarinvitado');
    Route::post('registrar_invitacion', [EventoSocialesController::class, 'registrar_invitacion'])->name('registrar_invitacion');
    Route::get('marcar_asistenciaqr/{invitacionId}', [EventoSocialesController::class, 'marcar_asistenciaqr'])->name('marcar_asistenciaqr');
});

Route::group(['middleware' => ['auth', 'can:Fotografo']], function () {
    // Rutas Autenticadas que solo pueden ser accedidas por usuarios con el rol "Fotografo"

    Route::get('abrir_eventosfotografos', [FotosController::class, 'abrir_eventosfotografos'])->name('abrir_eventosfotografos');
    Route::get('abrir_catalogo_evento/{id_evento}', [FotosController::class, 'abrir_catalogo_evento'])->name('abrir_catalogo_evento');
    Route::post('registrar_catalogo', [FotosController::class, 'registrar_catalogo'])->name('registrar_catalogo');
    Route::post('IA_DETECTION', [FotosController::class, 'IA_DETECTION'])->name('IA_DETECTION');
    Route::get('abrir_fotos_catalogos/{id_catalogo}', [FotosController::class, 'abrir_fotos_catalogos'])->name('abrir_fotos_catalogos');
});

Route::group(['middleware' => ['auth', 'can:Cliente']], function () {
    // Rutas Autenticadas que solo pueden ser accedidas por usuarios con el rol "Invitado"

    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('abrir_miusuario', [UsersController::class, 'abrir_miusuario'])->name('abrir_miusuario');
    Route::post('update_perfil', [UsersController::class, 'update_perfil'])->name('update_perfil');
    Route::post('cambiar_contraseña', [UsersController::class, 'cambiar_contraseña'])->name('cambiar_contraseña');
    Route::post('registrar_3imagenes', [UsersController::class, 'registrar_3imagenes'])->name('registrar_3imagenes');

    Route::get('abrir_eventosfotografos', [FotosController::class, 'abrir_eventosfotografos'])->name('abrir_eventosfotografos');
    Route::get('abrir_catalogo_evento/{id_evento}', [FotosController::class, 'abrir_catalogo_evento'])->name('abrir_catalogo_evento');
    Route::post('registrar_catalogo', [FotosController::class, 'registrar_catalogo'])->name('registrar_catalogo');
    Route::post('IA_DETECTION', [FotosController::class, 'IA_DETECTION'])->name('IA_DETECTION');
    Route::get('abrir_fotos_catalogos/{id_catalogo}', [FotosController::class, 'abrir_fotos_catalogos'])->name('abrir_fotos_catalogos');

    Route::get('abrir_creareventos', [EventoSocialesController::class, 'abrir_creareventos'])->name('abrir_creareventos');
    Route::post('registrar_evento', [EventoSocialesController::class, 'registrar_evento'])->name('registrar_evento');
    Route::get('abrir_alleventos', [EventoSocialesController::class, 'abrir_alleventos'])->name('abrir_alleventos');
    Route::delete('/eventos/{id}', [EventoSocialesController::class, 'eliminarEvento'])->name('eliminarEvento');
    Route::get('/getevento/{id}', [EventoSocialesController::class, 'getevento'])->name('getevento');



    Route::get('abrir_registrarinvitado/{id_evento}', [EventoSocialesController::class, 'abrir_registrarinvitado'])->name('abrir_registrarinvitado');
    Route::post('registrar_invitacion', [EventoSocialesController::class, 'registrar_invitacion'])->name('registrar_invitacion');
    Route::get('marcar_asistenciaqr/{invitacionId}', [EventoSocialesController::class, 'marcar_asistenciaqr'])->name('marcar_asistenciaqr');

    Route::get('abrir_suscripciones', [HomeController::class, 'abrir_suscripciones'])->name('abrir_suscripciones');
    // Rutas Autenticadas que solo pueden ser accedidas por usuarios con el rol "Organizador"
    Route::get('abrir_creareventos', [EventoSocialesController::class, 'abrir_creareventos'])->name('abrir_creareventos');
    Route::post('registrar_evento', [EventoSocialesController::class, 'registrar_evento'])->name('registrar_evento');
    Route::get('abrir_alleventos', [EventoSocialesController::class, 'abrir_alleventos'])->name('abrir_alleventos');
    Route::delete('/eventos/{id}', [EventoSocialesController::class, 'eliminarEvento'])->name('eliminarEvento');
    Route::get('/getevento/{id}', [EventoSocialesController::class, 'getevento'])->name('getevento');



    Route::get('abrir_registrarinvitado/{id_evento}', [EventoSocialesController::class, 'abrir_registrarinvitado'])->name('abrir_registrarinvitado');
    Route::post('registrar_invitacion', [EventoSocialesController::class, 'registrar_invitacion'])->name('registrar_invitacion');
    Route::get('marcar_asistenciaqr/{invitacionId}', [EventoSocialesController::class, 'marcar_asistenciaqr'])->name('marcar_asistenciaqr');
});
