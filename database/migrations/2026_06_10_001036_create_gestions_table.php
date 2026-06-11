<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gestiones', function (Blueprint $table) {
            $table->id();
            $table->integer('anio')->unique();
            $table->boolean('estado')->default(false);
            $table->date('fecha_apertura');
            $table->date('fecha_clausura')->nullable();
            $table->string('documento')->nullable(); // ruta en publica para documentos/
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gestiones');
    }
};
