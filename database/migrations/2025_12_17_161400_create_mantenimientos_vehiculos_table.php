<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mantenimientos_vehiculos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehiculo_id')->constrained()->onDelete('cascade');
            $table->date('fecha_mantenimiento');
            $table->string('tipo'); // preventivo, correctivo, etc.
            $table->text('descripcion');
            $table->decimal('costo', 10, 2)->default(0);
            $table->integer('kilometraje')->nullable();
            $table->string('taller')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
            
            $table->index(['vehiculo_id', 'fecha_mantenimiento']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mantenimientos_vehiculos');
    }
};

