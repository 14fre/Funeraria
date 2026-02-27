<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['carroza', 'ambulancia', 'van', 'microbus']);
            $table->string('placa')->unique();
            $table->string('marca');
            $table->string('modelo');
            $table->integer('ano');
            $table->integer('capacidad');
            $table->integer('kilometraje')->default(0);
            $table->enum('estado', ['disponible', 'en_servicio', 'mantenimiento', 'fuera_servicio'])->default('disponible');
            $table->foreignId('conductor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('observaciones')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['tipo', 'estado']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehiculos');
    }
};

