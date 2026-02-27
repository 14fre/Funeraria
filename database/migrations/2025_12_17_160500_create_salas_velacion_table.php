<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('salas_velacion', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->integer('capacidad');
            $table->string('ubicacion')->nullable();
            $table->text('servicios_incluidos')->nullable();
            $table->decimal('precio_hora', 10, 2)->default(0);
            $table->enum('estado', ['disponible', 'ocupada', 'mantenimiento', 'fuera_servicio'])->default('disponible');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salas_velacion');
    }
};

