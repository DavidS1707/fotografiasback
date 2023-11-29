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
        Schema::create('catalogos', function (Blueprint $table) {
            $table->id();
            $table->string('title_catalogo'); 
            $table->integer('precio_catalogo')->nullable(); 
            $table->unsignedBigInteger('evento_id'); 
            $table->foreign('evento_id')->references('id')->on('eventos');
            $table->unsignedBigInteger('fotografo_id'); 
            $table->foreign('fotografo_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalogos');
    }
};
