<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo_proveedor', ['PERSONA', 'EMPRESA'])->default('EMPRESA');
            $table->string('nombre', 150);
            $table->string('razon_social', 200)->nullable();
            $table->string('rfc', 20)->nullable()->unique();
            $table->string('contacto', 150)->nullable();
            $table->string('telefono', 30)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('sitio_web', 200)->nullable();
            $table->string('calle', 150)->nullable();
            $table->string('numero_exterior', 30)->nullable();
            $table->string('numero_interior', 30)->nullable();
            $table->string('colonia', 100)->nullable();
            $table->string('municipio', 100)->nullable();
            $table->string('estado', 100)->nullable();
            $table->string('codigo_postal', 10)->nullable();
            $table->text('notas')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->index(['activo', 'nombre']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proveedores');
    }
};
