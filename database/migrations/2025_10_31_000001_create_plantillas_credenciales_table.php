<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plantillas_credenciales', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('imagen_frontal')->nullable();
            $table->string('imagen_trasera')->nullable();
            $table->integer('ancho_mm')->default(86); // Tamaño estándar de credencial: 86mm
            $table->integer('alto_mm')->default(54); // 54mm
            $table->json('campos_frontal')->nullable(); // Posiciones de campos en el frente
            $table->json('campos_trasera')->nullable(); // Posiciones de campos en la parte trasera
            $table->boolean('activa')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plantillas_credenciales');
    }
};
