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
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->string('title_evento');
            $table->string('descripcion_evento');
            $table->date('fecha_evento');
            $table->time('hora_evento');
            $table->string('ubicacion');
            $table->unsignedBigInteger('organizador_id'); // Agrega una clave foránea a 'users'
            $table->foreign('organizador_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
