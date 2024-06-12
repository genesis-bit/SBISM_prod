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
        Schema::create('livros', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 80);
            $table->string('autor', 80);
            $table->string('editora',60);
            $table->year('ano_edicao');
            $table->unsignedBigInteger('genero_livro_id');
            $table->text('observacao')->nullable();            
            $table->timestamps();
            $table->foreign('genero_livro_id')->references('id')->on('genero_livros');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('livros');
    }
};
