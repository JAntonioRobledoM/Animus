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
            $table->integer('year')->nullable(); // Año, permite valores negativos para AC
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recuerdos', function (Blueprint $table) {
            $table->dropColumn('year');
        });
    }
};