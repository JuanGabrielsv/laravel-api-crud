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
        Schema::table('concierto', function (Blueprint $table) {
            $table->foreignId('banda_id')->constrained('banda')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('concierto', function (Blueprint $table) {
            $table->dropForeign(['banda_id']);
            $table->dropColumn('banda_id');
        });
    }
};
