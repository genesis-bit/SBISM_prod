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
        Schema::create('prateleira_livros', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('livro_id');
            $table->unsignedBigInteger('prateleira_id');
            $table->string('posicao');
            $table->integer('quantidade_livro');
            $table->timestamps();
            $table->foreign('livro_id')->references('id')->on('livros');
            $table->foreign('prateleira_id')->references('id')->on('prateleiras');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prateleira_livros');
    }
};
