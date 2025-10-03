<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url')->nullable();
            $table->string('slug')->nullable();
            $table->unsignedBigInteger('parent')->default(0);
            $table->integer('order')->default(0);
            $table->boolean('enabled')->default(true);
            $table->string('type')->nullable(); // empresa, sucursal, empleado
            $table->string('data_id')->nullable(); // ID del registro relacionado
            $table->timestamps();
            
            $table->index(['parent', 'order', 'enabled']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};