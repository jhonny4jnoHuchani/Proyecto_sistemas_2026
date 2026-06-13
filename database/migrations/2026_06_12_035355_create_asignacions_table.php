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

            // gestion_id: por ahora no se usa, queda nullable
            $table->foreignId('gestion_id')->nullable()->constrained('gestiones');

            // docente_id: nullable porque la materia puede asignarse al curso
            // antes de elegir al docente
            $table->foreignId('docente_id')->nullable()->constrained('docentes');

            $table->foreignId('materia_id')->nullable()->constrained('materias');
            $table->foreignId('curso_id')->nullable()->constrained('cursos');

            $table->boolean('estado')->default(true); // Control de eliminación lógica
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignaciones');
    }
};