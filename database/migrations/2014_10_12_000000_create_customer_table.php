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
        Schema::create('customers', function (Blueprint $table) {
            $table->string('dni',45)->primary('dni')->comment('Documento de Identidad');
            $table->integer('id_reg')->comment('');
            $table->integer('id_com')->comment('');
            $table->string('email', 120)->unique('email', 'email_UNIQUE')->comment('Correo Electrónico');
            $table->string('name', 45)->comment('Nombre');
            $table->string('last_name', 45)->comment('Apellido');
            $table->string('address')->comment('Dirección');
            $table->dateTime('date_reg')->default(now())->comment('Fecha y hora del registro');
            $table->enum('status', ['A', 'I', 'trash'])->default('A')->comment('estado del registro:\nA : Activo\nI : Desactivo\ntrash : Registro eliminado');
            $table->index(['id_com', 'id_reg'], 'fk_customers_communes1_idx')->comment('');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
