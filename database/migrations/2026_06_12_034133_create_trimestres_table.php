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
        Schema::create('trimestres', function (Blueprint $table) {
            $table->id();
            
            // Relación con la tabla gestiones
            $table->foreignId('gestion_id')->constrained('gestiones');
            
            $table->string('nombre', 50); // Ej: '1er Trimestre'
            
            // Estándar de eliminación lógica
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trimestres');
    }
};
