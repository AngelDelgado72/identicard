<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sucursal', function (Blueprint $table) {
            $table->id('idSucursal');
            $table->unsignedBigInteger('idEmpresas');
            $table->string('Nombre', 100);
            $table->string('Direccion', 200)->nullable();
            $table->timestamps();

            $table->foreign('idEmpresas')
                  ->references('idEmpresas')->on('empresas')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sucursal');
    }
};
