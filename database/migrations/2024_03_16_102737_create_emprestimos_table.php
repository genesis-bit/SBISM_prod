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
        Schema::create('emprestimos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('livro_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('tipo_emprestimo_id');
            $table->unsignedBigInteger('bibliotecario_id');
            $table->dateTime('data_emprestimo');            
            $table->timestamps();
            $table->foreign('livro_id')->references('id')->on('livros');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('bibliotecario_id')->references('id')->on('users');
            $table->foreign('tipo_emprestimo_id')->references('id')->on('tipo_emprestimos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emprestimos');
    }
};
