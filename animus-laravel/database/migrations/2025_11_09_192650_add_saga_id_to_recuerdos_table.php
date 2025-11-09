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
            $table->foreignId('saga_id')->nullable()->constrained('sagas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recuerdos', function (Blueprint $table) {
            $table->dropForeignKeyIfExists(['saga_id']);
            $table->dropColumn('saga_id');
        });
    }
};
