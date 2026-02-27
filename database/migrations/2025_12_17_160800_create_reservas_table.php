<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('servicio_funerario_id')->nullable()->constrained('servicios_funerarios')->onDelete('cascade');
            $table->string('tipo_recurso'); // 'sala' o 'vehiculo'
            $table->unsignedBigInteger('recurso_id'); // ID de sala o vehículo
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->time('hora_inicio')->nullable();
            $table->time('hora_fin')->nullable();
            $table->enum('estado', ['reservada', 'confirmada', 'cancelada', 'completada'])->default('reservada');
            $table->text('observaciones')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['tipo_recurso', 'recurso_id', 'fecha_inicio']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};

