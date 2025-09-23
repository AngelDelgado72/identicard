<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('permisos', function (Blueprint $table) {
            $table->bigIncrements('idPermiso');
            $table->string('nombre', 100);
            $table->string('descripcion', 255)->nullable();
            $table->string('modulo', 50); // empleados, empresas, sucursales, usuarios
            $table->string('accion', 50); // crear, editar, eliminar, ver
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permisos');
    }
};
