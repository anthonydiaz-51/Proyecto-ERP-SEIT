<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\OrdenServicioController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\PagoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:1,2'])->group(function () {
    Route::get('/admin/usuarios', function () {
        return 'middleware correcto';
    })->name('admin.usuarios.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/modulo-pendiente/{modulo}', function ($modulo) {
        return view('modulo-pendiente', compact('modulo'));
    })->name('modulo.pendiente');
});

Route::middleware('auth')->prefix('comercial')->name('comercial.')->group(function () {
    Route::resource('clientes', ClienteController::class);
    Route::resource('servicios', ServicioController::class);
    Route::resource('cotizaciones', CotizacionController::class);
    
});

Route::middleware('auth')->prefix('sistemas')->name('sistemas.')->group(function () {
    Route::get('ordenes-servicio', [OrdenServicioController::class, 'index'])->name('ordenes.index');
    Route::get('ordenes-servicio/create', [OrdenServicioController::class, 'create'])->name('ordenes.create');
    Route::post('ordenes-servicio', [OrdenServicioController::class, 'store'])->name('ordenes.store');
    Route::get('ordenes-servicio/{orden}/edit', [OrdenServicioController::class, 'edit'])->name('ordenes.edit');
    Route::put('ordenes-servicio/{orden}', [OrdenServicioController::class, 'update'])->name('ordenes.update');
    Route::delete('ordenes-servicio/{orden}', [OrdenServicioController::class, 'destroy'])->name('ordenes.destroy');
});

Route::middleware(['auth', 'role:1,2'])->prefix('administracion')->name('administracion.')->group(function () {
    Route::resource('usuarios', UsuarioController::class);
});


//Controlador de Venta
Route::middleware('auth')->prefix('comercial')->name('comercial.')->group(function () {
    Route::resource('clientes', ClienteController::class);
    Route::resource('servicios', ServicioController::class);
    Route::resource('cotizaciones', CotizacionController::class);
    Route::post('cotizaciones/{cotizacion}/generar-orden', [OrdenServicioController::class, 'desdeCotizacion'])->name('cotizaciones.generar-orden');

    Route::get('ventas', [VentaController::class, 'index'])
        ->middleware('role:1,2,3')
        ->name('ventas.index');
});

//Controlaor/ruta de Pagos
Route::middleware(['auth', 'role:1,2,3'])->prefix('finanzas')->name('finanzas.')->group(function () {
    Route::resource('pagos', PagoController::class)->except(['show', 'destroy']);
});

require __DIR__.'/auth.php';