<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proveedor_id')->constrained('proveedores')->restrictOnDelete();
            $table->unsignedBigInteger('usuario_id')->nullable()->index();
            $table->date('fecha');
            $table->string('referencia_proveedor', 100)->nullable();
            $table->decimal('tasa_impuesto', 5, 2)->default(16);
            $table->decimal('subtotal', 18, 2)->default(0);
            $table->decimal('impuestos', 18, 2)->default(0);
            $table->decimal('total', 18, 2)->default(0);
            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->index(['fecha', 'proveedor_id']);
        });

        Schema::create('compra_detalle', function (Blueprint $table) {
            $table->id();
            $table->foreignId('compra_id')->constrained('compras')->cascadeOnDelete();
            // productos is part of the legacy schema and its id type may differ between installations.
            $table->unsignedBigInteger('producto_id')->index();
            $table->decimal('cantidad', 10, 2);
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('subtotal', 18, 2);
            $table->string('ubicacion', 100)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('compra_detalle');
        Schema::dropIfExists('compras');
    }
};
