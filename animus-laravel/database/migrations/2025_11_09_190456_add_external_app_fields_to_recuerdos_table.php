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
            $table->boolean('necesita_app_externa')->default(false)->after('longitud');
            $table->string('ruta_app_externa', 500)->nullable()->after('necesita_app_externa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recuerdos', function (Blueprint $table) {
            $table->dropColumn(['necesita_app_externa', 'ruta_app_externa']);
        });
    }
};
