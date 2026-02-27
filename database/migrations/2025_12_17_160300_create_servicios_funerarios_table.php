<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('servicios_funerarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('afiliado_id')->constrained()->onDelete('cascade');
            $table->foreignId('beneficiario_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('tipo', ['velacion', 'velacion_virtual', 'cremacion', 'traslado_nacional', 'traslado_internacional']);
            $table->enum('estado', ['solicitado', 'programado', 'en_proceso', 'completado', 'cancelado'])->default('solicitado');
            $table->date('fecha_solicitud');
            $table->date('fecha_servicio')->nullable();
            $table->time('hora_servicio')->nullable();
            $table->foreignId('coordinador_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('observaciones')->nullable();
            $table->json('detalles_servicio')->nullable(); // JSON con detalles específicos por tipo
            $table->decimal('costo_adicional', 10, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['afiliado_id', 'estado']);
            $table->index('fecha_servicio');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('servicios_funerarios');
    }
};

