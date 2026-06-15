<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notas', function (Blueprint $table) {
            $table->id('id_nota');
            $table->unsignedBigInteger('id_inscripcion');
            $table->unsignedBigInteger('id_asignacion');
            $table->unsignedBigInteger('id_trimestre');
            
            $table->decimal('nota_final', 5, 2)->nullable()->default(0);
            
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('id_inscripcion')->references('id_inscripcion')->on('inscripciones')->onDelete('cascade');
            $table->foreign('id_asignacion')->references('id')->on('asignaciones')->onDelete('cascade');
            
            // CORREGIDO: trimestres usa 'id' como primary key
            $table->foreign('id_trimestre')->references('id')->on('trimestres')->onDelete('cascade');
            
            $table->unique(['id_inscripcion', 'id_asignacion', 'id_trimestre'], 'unique_nota');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notas');
    }
};