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
        Schema::create('paquetes', function (Blueprint $table) {
            $table->bigIncrements('idPaquete');
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->date('fecha_creacion');
            $table->enum('estatus', ['en_creacion', 'confirmado'])->default('en_creacion');
            $table->unsignedBigInteger('creado_por');
            $table->timestamps();

            // Clave foránea para el usuario que creó el paquete
            $table->foreign('creado_por')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paquetes');
    }
};
