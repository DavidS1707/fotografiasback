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
        Schema::create('ia_usuarios_foto', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('foto_id'); 
            $table->foreign('foto_id')->references('id')->on('fotos_catalogo');
            $table->unsignedBigInteger('usuario_id'); 
            $table->foreign('usuario_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ia_usuarios_foto');
    }
};
