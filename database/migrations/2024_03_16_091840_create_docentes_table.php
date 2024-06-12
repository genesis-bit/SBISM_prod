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
        Schema::create('docentes', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->string('nome', 60);
            $table->unsignedBigInteger('grau_academico_id');
            $table->unsignedBigInteger('especialidade_id');
            $table->string('numero_professor')->unique();
            $table->string('numero_bilhete', 30)->unique();
            $table->string('contacto', 25)->nullable();
            $table->foreign('id')->references('id')->on('users');
            $table->foreign('grau_academico_id')->references('id')->on('grau_academicos');
            $table->foreign('especialidade_id')->references('id')->on('especialidades');
            $table->primary('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('docentes');
    }
};
