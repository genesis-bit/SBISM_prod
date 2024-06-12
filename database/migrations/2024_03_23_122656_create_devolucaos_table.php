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
        Schema::create('devolucaos', function (Blueprint $table) {
           $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('bibliotecario_id');
            $table->dateTime('data');            
            $table->timestamps();
            $table->primary('id');
            $table->foreign('id')->references('id')->on('emprestimos');
            $table->foreign('bibliotecario_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devolucaos');
    }
};
