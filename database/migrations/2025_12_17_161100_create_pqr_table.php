<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pqr', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('afiliado_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('tipo', ['peticion', 'queja', 'reclamo']);
            $table->string('asunto');
            $table->text('descripcion');
            $table->enum('estado', ['pendiente', 'en_revision', 'respondida', 'cerrada'])->default('pendiente');
            $table->text('respuesta')->nullable();
            $table->foreignId('respondido_por')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('fecha_respuesta')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['user_id', 'estado']);
            $table->index('tipo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pqr');
    }
};

