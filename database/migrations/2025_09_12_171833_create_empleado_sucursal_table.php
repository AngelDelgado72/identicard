<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('empleado_sucursal', function (Blueprint $table) {
            $table->bigIncrements('idEmpleadoSucursal');
            $table->unsignedBigInteger('idEmpleado');
            $table->unsignedBigInteger('idSucursal');
            $table->timestamps();

            $table->foreign('idEmpleado')
                  ->references('idEmpleado')->on('empleados')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();

            $table->foreign('idSucursal')
                  ->references('idSucursal')->on('sucursal')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('empleado_sucursal');
    }
};