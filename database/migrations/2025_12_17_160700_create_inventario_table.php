<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventario', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->enum('tipo', ['urna', 'ataud', 'flores', 'velas', 'otros']);
            $table->string('marca')->nullable();
            $table->string('material')->nullable();
            $table->string('proveedor')->nullable();
            $table->integer('stock_actual')->default(0);
            $table->integer('stock_minimo')->default(0);
            $table->decimal('precio_compra', 10, 2)->default(0);
            $table->decimal('precio_venta', 10, 2)->default(0);
            $table->enum('estado', ['disponible', 'agotado', 'discontinuado'])->default('disponible');
            $table->date('fecha_ingreso')->nullable();
            $table->text('descripcion')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['tipo', 'estado']);
            $table->index('stock_actual');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventario');
    }
};

