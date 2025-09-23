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
        Schema::create('perfil_permiso', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('idPerfil');
            $table->unsignedBigInteger('idPermiso');
            $table->timestamps();

            $table->foreign('idPerfil')->references('idPerfil')->on('perfiles')->cascadeOnDelete();
            $table->foreign('idPermiso')->references('idPermiso')->on('permisos')->cascadeOnDelete();
            
            $table->unique(['idPerfil', 'idPermiso']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perfil_permiso');
    }
};
