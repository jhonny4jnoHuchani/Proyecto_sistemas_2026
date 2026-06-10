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
        Schema::create('administrativos', function (Blueprint $table) {
            $table->id('id_admin');
            //Llave foranea a users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->string('nombre',100);
            $table->string('apellido',100);
            $table->string('ci',20)->unique();
            $table->string('cargo',100);

            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('administrativos');
    }
};
