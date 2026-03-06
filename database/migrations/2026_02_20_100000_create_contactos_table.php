<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contactos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('email');
            $table->string('telefono')->nullable();
            $table->string('asunto');
            $table->text('mensaje');
            $table->boolean('leido')->default(false);
            $table->string('ip', 45)->nullable();
            $table->timestamps();

            $table->index('leido');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contactos');
    }
};
