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
        Schema::create('asignaciones', function (Blueprint $table) {
            $table->id();
            // Llaves foráneas limpias hacia los catálogos correspondientes
            $table->foreignId('gestion_id')->constrained('gestiones');
            $table->foreignId('docente_id')->constrained('docentes');
            $table->foreignId('materia_id')->constrained('materias');
            $table->foreignId('curso_id')->constrained('cursos');
            
            $table->boolean('estado')->default(true); // Control de eliminación lógica
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignacions');
    }
};
