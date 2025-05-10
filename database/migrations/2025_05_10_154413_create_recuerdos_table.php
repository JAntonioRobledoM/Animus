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
        Schema::create('recuerdos', function (Blueprint $table) {
            $table->id();
            $table->string('img')->nullable(); // Ruta a la imagen del recuerdo
            $table->string('title'); // Título del recuerdo
            $table->string('subtitle')->nullable(); // Subtítulo del recuerdo
            $table->string('path')->nullable(); // Ruta o ubicación del recuerdo
            $table->integer('position')->default(0); // Posición para ordenar los recuerdos
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recuerdos');
    }
};