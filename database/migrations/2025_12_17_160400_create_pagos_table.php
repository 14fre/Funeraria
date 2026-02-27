<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('afiliado_id')->constrained()->onDelete('cascade');
            $table->foreignId('plan_exequial_id')->constrained('planes_exequiales')->onDelete('restrict');
            $table->decimal('monto', 10, 2);
            $table->enum('metodo_pago', ['efectivo', 'tarjeta', 'transferencia', 'pse', 'online']);
            $table->enum('estado', ['pendiente', 'aprobado', 'rechazado', 'anulado'])->default('pendiente');
            $table->string('referencia')->nullable();
            $table->string('numero_recibo')->nullable();
            $table->date('fecha_pago')->nullable();
            $table->date('periodo_desde')->nullable();
            $table->date('periodo_hasta')->nullable();
            $table->foreignId('procesado_por')->nullable()->constrained('users')->onDelete('set null');
            $table->text('observaciones')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['afiliado_id', 'estado']);
            $table->index('fecha_pago');
            $table->index('numero_recibo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};

