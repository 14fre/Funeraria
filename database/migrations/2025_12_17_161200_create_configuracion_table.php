<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('configuracion', function (Blueprint $table) {
            $table->id();
            $table->string('clave')->unique();
            $table->text('valor')->nullable();
            $table->string('tipo')->default('text'); // text, number, boolean, json
            $table->text('descripcion')->nullable();
            $table->string('grupo')->nullable(); // general, empresa, integraciones, etc.
            $table->timestamps();
            
            $table->index('clave');
            $table->index('grupo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configuracion');
    }
};

