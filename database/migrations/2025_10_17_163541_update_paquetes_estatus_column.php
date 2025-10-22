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
        Schema::table('paquetes', function (Blueprint $table) {
            // Cambiar el enum para incluir 'autorizado'
            $table->enum('estatus', ['en_creacion', 'confirmado', 'autorizado'])->default('en_creacion')->change();
        });
    }  

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paquetes', function (Blueprint $table) {
            // Revertir al enum original
            $table->enum('estatus', ['en_creacion', 'confirmado'])->default('en_creacion')->change();
        });
    }
};
