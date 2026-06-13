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
        Schema::create('inscripciones', function (Blueprint $table) {
            $table->id('id_inscripcion');

            $table->foreignId('id_estudiante')->constrained('estudiantes');
            $table->foreignId('id_curso')->constrained('cursos');
            $table->foreignId('id_gestion')->nullable()->constrained('gestiones');

            $table->date('fecha_inscripcion');
            $table->boolean('estado')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscripciones');
    }
};