<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->bigIncrements('idEmpleado');
            $table->string('Nombre', 100);
            $table->string('Apellido', 100);
            $table->string('Correo', 120)->unique()->nullable();
            $table->string('TipoSangre', 5)->nullable();
            $table->string('NumeroSeguroSocial', 20)->unique()->nullable();
            $table->string('CodigoRH', 10)->nullable();
            $table->string('Departamento', 100)->nullable(); // <-- Nuevo campo
            $table->string('RFC', 20)->nullable();//
            $table->string('Puesto', 100)->nullable();
            $table->string('Firma', 255)->nullable();
            $table->string('Foto', 255)->nullable();
            $table->unsignedBigInteger('idSucursal')->nullable(); // <-- Cambia aquí            
            $table->timestamps();

            $table->foreign('idSucursal')
                  ->references('idSucursal')->on('sucursal') // <-- Corregido a plural
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};