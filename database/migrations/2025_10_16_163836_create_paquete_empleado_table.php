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
        Schema::create('paquete_empleado', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('idPaquete');
            $table->unsignedBigInteger('idEmpleado');
            $table->timestamps();

            // Claves foráneas
            $table->foreign('idPaquete')->references('idPaquete')->on('paquetes')->cascadeOnDelete();
            $table->foreign('idEmpleado')->references('idEmpleado')->on('empleados')->cascadeOnDelete();

            // Evitar duplicados
            $table->unique(['idPaquete', 'idEmpleado']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paquete_empleado');
    }
};
