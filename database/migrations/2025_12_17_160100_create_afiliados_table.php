<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('afiliados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('plan_exequial_id')->constrained('planes_exequiales')->onDelete('restrict');
            $table->string('numero_afiliacion')->unique();
            $table->date('fecha_afiliacion');
            $table->enum('estado', ['activo', 'suspendido', 'cancelado', 'mora'])->default('activo');
            $table->foreignId('asesor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('observaciones')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('numero_afiliacion');
            $table->index('estado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('afiliados');
    }
};

