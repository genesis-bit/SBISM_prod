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
        Schema::create('estudantes', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->string('nome', 60);
            $table->unsignedBigInteger('curso_id');
            $table->string('numero_estudante', 30)->unique();
            $table->string('numero_bilhete', 30)->unique();
            $table->string('contacto', 25)->nullable();
            $table->foreign('id')->references('id')->on('users');
            $table->foreign('curso_id')->references('id')->on('cursos');
            $table->primary('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudantes');
    }
};
