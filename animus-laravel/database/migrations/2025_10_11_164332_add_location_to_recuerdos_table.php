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
        Schema::table('recuerdos', function (Blueprint $table) {
            $table->string('lugar')->nullable()->after('year'); // Nombre del lugar (ciudad, país, región)
            $table->decimal('latitud', 10, 8)->nullable()->after('lugar'); // Latitud con 8 decimales de precisión
            $table->decimal('longitud', 11, 8)->nullable()->after('latitud'); // Longitud con 8 decimales de precisión
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recuerdos', function (Blueprint $table) {
            $table->dropColumn(['lugar', 'latitud', 'longitud']);
        });
    }
};
