<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\OrdenServicioController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\MovimientoInventarioController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\CompraController;

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

Route::middleware('auth')->prefix('inventario')->name('inventario.')->group(function () {
    Route::get('/', [ProductoController::class, 'index'])->name('index');
    Route::resource('productos', ProductoController::class)->except(['index', 'show']);
    Route::get('movimientos', [MovimientoInventarioController::class, 'index'])->name('movimientos.index');
    Route::get('movimientos/create', [MovimientoInventarioController::class, 'create'])->name('movimientos.create');
    Route::post('movimientos', [MovimientoInventarioController::class, 'store'])->name('movimientos.store');
});

Route::middleware('auth')->prefix('compras')->name('compras.')->group(function () {
    Route::get('/', [CompraController::class, 'index'])->name('index');
    Route::get('create', [CompraController::class, 'create'])->name('create');
    Route::post('/', [CompraController::class, 'store'])->name('store');
    Route::get('{compra}', [CompraController::class, 'show'])->whereNumber('compra')->name('show');

    Route::resource('proveedores', ProveedorController::class)
        ->except(['show'])
        ->parameters(['proveedores' => 'proveedor']);
});

require __DIR__.'/auth.php';
