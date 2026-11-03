<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Creates the original ERP tables when installing into a new database.
     * Existing manually-created tables are adopted unchanged.
     */
    public function up(): void
    {
        if (!Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {
                $table->id();
                $table->string('nombre', 50)->nullable();
                $table->string('descripcion', 255)->nullable();
                $table->boolean('activo')->nullable();
            });
        }

        if (!Schema::hasTable('usuarios')) {
            Schema::create('usuarios', function (Blueprint $table) {
                $table->id();
                $table->string('nombre', 100)->nullable();
                $table->string('apellido', 100)->nullable();
                $table->string('email', 150)->nullable();
                $table->string('password')->nullable();
                $table->foreignId('rol_id')->nullable()->constrained('roles');
                $table->boolean('activo')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('clientes')) {
            Schema::create('clientes', function (Blueprint $table) {
                $table->id();
                $table->enum('tipo_cliente', ['PERSONA', 'EMPRESA'])->nullable();
                $table->string('nombre', 150)->nullable();
                $table->string('razon_social', 200)->nullable();
                $table->string('rfc', 20)->nullable();
                $table->string('telefono', 30)->nullable();
                $table->string('email', 150)->nullable();
                $table->text('notas')->nullable();
                $table->boolean('activo')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('contactos_cliente')) {
            Schema::create('contactos_cliente', function (Blueprint $table) {
                $table->id();
                $table->foreignId('cliente_id')->nullable()->constrained('clientes');
                $table->string('nombre', 250)->nullable();
                $table->string('puesto', 100)->nullable();
                $table->string('telefono', 30)->nullable();
                $table->string('email', 150)->nullable();
                $table->boolean('principal')->nullable();
                $table->boolean('activo')->nullable();
            });
        }

        if (!Schema::hasTable('direcciones_cliente')) {
            Schema::create('direcciones_cliente', function (Blueprint $table) {
                $table->id();
                $table->foreignId('cliente_id')->nullable()->constrained('clientes');
                $table->string('tipo', 30)->nullable();
                $table->string('calle', 150)->nullable();
                $table->string('numero', 20)->nullable();
                $table->string('colonia', 100)->nullable();
                $table->string('municipio', 100)->nullable();
                $table->string('estado', 100)->nullable();
                $table->string('cp', 10)->nullable();
                $table->text('referencias')->nullable();
                $table->boolean('principal')->nullable();
            });
        }

        if (!Schema::hasTable('categorias_servicio')) {
            Schema::create('categorias_servicio', function (Blueprint $table) {
                $table->id();
                $table->enum('nombre', [
                    'Soporte técnico',
                    'Redes / Cableado estructurado',
                    'Sistemas de seguridad',
                    'Diseño web / Hosting / Dominios',
                    'Venta equipo',
                    'Educación',
                    'Publicidad',
                ])->nullable();
                $table->text('descripcion')->nullable();
                $table->boolean('activo')->nullable();
            });
        }

        if (!Schema::hasTable('servicios')) {
            Schema::create('servicios', function (Blueprint $table) {
                $table->id();
                $table->foreignId('categoria_id')->nullable()->constrained('categorias_servicio');
                // The live ERP database and its current models use `servicio`.
                $table->string('servicio', 150);
                $table->text('descripcion')->nullable();
                $table->decimal('precio_base', 10, 2)->nullable();
                $table->string('tipo_precio', 30)->nullable();
                $table->boolean('activo')->nullable();
                $table->boolean('promocion')->nullable();
            });
        }

        if (!Schema::hasTable('categorias_producto')) {
            Schema::create('categorias_producto', function (Blueprint $table) {
                $table->id();
                $table->enum('nombre', [
                    'Componentes',
                    'Cables',
                    'Consumibles',
                    'Accesorios',
                    'Equipo de computo',
                    'CCTV',
                    'Redes',
                    'Papelería',
                ])->nullable();
                $table->text('descripcion')->nullable();
                $table->boolean('activo')->nullable();
            });
        }

        if (!Schema::hasTable('productos')) {
            Schema::create('productos', function (Blueprint $table) {
                $table->id();
                $table->foreignId('categoria_id')->nullable()->constrained('categorias_producto');
                $table->string('codigo', 50)->nullable();
                $table->string('nombre', 150)->nullable();
                $table->text('descripcion')->nullable();
                $table->decimal('precio_compra', 10, 2)->nullable();
                $table->decimal('precio_venta', 10, 2)->nullable();
                $table->integer('stock_minimo')->nullable();
                $table->boolean('activo')->nullable();
            });
        }

        if (!Schema::hasTable('cotizaciones')) {
            Schema::create('cotizaciones', function (Blueprint $table) {
                $table->id();
                $table->string('folio', 30)->nullable();
                $table->foreignId('cliente_id')->nullable()->constrained('clientes');
                $table->foreignId('usuario_id')->nullable()->constrained('usuarios');
                $table->date('fecha')->nullable();
                $table->date('vigencia')->nullable();
                $table->string('estado', 30)->nullable();
                $table->decimal('subtotal', 10, 2)->nullable();
                $table->decimal('descuento', 10, 2)->nullable();
                $table->decimal('impuestos', 10, 2)->nullable();
                $table->decimal('total', 10, 2)->nullable();
                $table->text('observaciones')->nullable();
            });
        }

        if (!Schema::hasTable('cotizacion_detalle')) {
            Schema::create('cotizacion_detalle', function (Blueprint $table) {
                $table->id();
                $table->foreignId('cotizacion_id')->nullable()->constrained('cotizaciones');
                $table->foreignId('servicio_id')->nullable()->constrained('servicios');
                $table->foreignId('producto_id')->nullable()->constrained('productos');
                $table->string('descripcion', 255)->nullable();
                $table->decimal('cantidad', 10, 2)->nullable();
                $table->decimal('precio_unitario', 10, 2)->nullable();
                $table->decimal('descuento', 10, 2)->nullable();
                $table->decimal('subtotal', 10, 2)->nullable();
            });
        }

        if (!Schema::hasTable('ordenes_servicio')) {
            Schema::create('ordenes_servicio', function (Blueprint $table) {
                $table->id();
                $table->string('folio', 30)->nullable();
                $table->foreignId('cliente_id')->nullable()->constrained('clientes');
                $table->foreignId('cotizacion_id')->nullable()->constrained('cotizaciones');
                $table->foreignId('tecnico_id')->nullable()->constrained('usuarios');
                $table->foreignId('usuario_registro_id')->nullable()->constrained('usuarios');
                $table->dateTime('fecha_recepcion')->nullable();
                $table->dateTime('fecha_compromiso')->nullable();
                $table->dateTime('fecha_entrega')->nullable();
                $table->enum('estado', [
                    'RECIBIDO', 'DIAGNOSTICO', 'COTIZACION', 'AUTORIZADO',
                    'EN_PROCESO', 'LISTO', 'ENTREGADO', 'CANCELADO',
                ])->default('RECIBIDO');
                $table->string('prioridad', 20)->nullable();
                $table->text('descripcion_falla')->nullable();
                $table->text('diagnostico')->nullable();
                $table->text('solucion')->nullable();
                $table->text('observaciones')->nullable();
                $table->decimal('costo_total', 10, 2)->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('orden_servicio_detalle')) {
            Schema::create('orden_servicio_detalle', function (Blueprint $table) {
                $table->id();
                $table->foreignId('orden_id')->nullable()->constrained('ordenes_servicio');
                $table->foreignId('servicio_id')->nullable()->constrained('servicios');
                $table->decimal('cantidad', 10, 2)->nullable();
                $table->decimal('precio_unitario', 10, 2)->nullable();
                $table->decimal('descuento', 10, 2)->nullable();
                $table->decimal('subtotal', 10, 2)->nullable();
                $table->text('observaciones')->nullable();
            });
        }

        if (!Schema::hasTable('pagos')) {
            Schema::create('pagos', function (Blueprint $table) {
                $table->id();
                $table->foreignId('orden_id')->nullable()->constrained('ordenes_servicio');
                $table->dateTime('fecha')->nullable();
                $table->decimal('monto', 10, 2)->nullable();
                $table->enum('metodo_pago', ['EFECTIVO', 'TRANSFERENCIA', 'TARJETA', 'DEPOSITO', 'OTRO'])->nullable();
                $table->string('referencia', 100)->nullable();
                $table->text('observaciones')->nullable();
                $table->foreignId('usuario_id')->nullable()->constrained('usuarios');
            });
        }

        if (!Schema::hasTable('inventario')) {
            Schema::create('inventario', function (Blueprint $table) {
                $table->id();
                $table->foreignId('producto_id')->nullable()->constrained('productos');
                $table->decimal('existencia', 10, 2)->nullable();
                $table->string('ubicacion', 100)->nullable();
                $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            });
        }

        if (!Schema::hasTable('movimientos_inventario')) {
            Schema::create('movimientos_inventario', function (Blueprint $table) {
                $table->id();
                $table->foreignId('producto_id')->nullable()->constrained('productos');
                $table->enum('tipo', ['ENTRADA', 'SALIDA', 'AJUSTE'])->nullable();
                $table->decimal('cantidad', 10, 2)->nullable();
                $table->string('referencia', 100)->nullable();
                $table->string('motivo', 255)->nullable();
                $table->foreignId('usuario_id')->nullable()->constrained('usuarios');
                $table->timestamp('created_at')->useCurrent()->useCurrentOnUpdate();
            });
        }
    }

    /**
     * The baseline adopts legacy tables too, so it must never drop them on rollback.
     */
    public function down(): void
    {
        // Intentionally irreversible to protect existing ERP data.
    }
};
