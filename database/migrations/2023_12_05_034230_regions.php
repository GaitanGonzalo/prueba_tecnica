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
        Schema::create('regions', function (Blueprint $table){
            $table->integer('id_reg')->autoIncrement()->comment('');
            $table->string('description', 90)->comment('');
            $table->enum('status', ['A', 'I', 'trash'])->default('A')->comment('estado del registro:\nA : Activo\nI : Desactivo\ntrash : Registro eliminado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regions');
    }
};
