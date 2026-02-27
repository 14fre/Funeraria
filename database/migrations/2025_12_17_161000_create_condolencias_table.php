<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('condolencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('obituario_id')->constrained()->onDelete('cascade');
            $table->string('nombre');
            $table->string('email')->nullable();
            $table->text('mensaje');
            $table->boolean('aprobado')->default(false);
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
            
            $table->index(['obituario_id', 'aprobado']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('condolencias');
    }
};

