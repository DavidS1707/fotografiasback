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
        Schema::create('fotos_usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('ruta_imagen');
            $table->unsignedBigInteger('usuario_id'); // Agrega una clave foránea a 'users'
            $table->foreign('usuario_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fotos_usuarios');
    }
};
