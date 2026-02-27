<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('obituarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('servicio_funerario_id')->nullable()->constrained('servicios_funerarios')->onDelete('set null');
            $table->string('nombre_completo');
            $table->date('fecha_nacimiento')->nullable();
            $table->date('fecha_fallecimiento');
            $table->string('lugar_fallecimiento')->nullable();
            $table->text('biografia')->nullable();
            $table->text('mensaje_familia')->nullable();
            $table->string('foto')->nullable();
            $table->date('fecha_velacion')->nullable();
            $table->string('lugar_velacion')->nullable();
            $table->date('fecha_sepultura')->nullable();
            $table->string('lugar_sepultura')->nullable();
            $table->boolean('publicado')->default(false);
            $table->integer('visitas')->default(0);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['publicado', 'fecha_fallecimiento']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('obituarios');
    }
};

