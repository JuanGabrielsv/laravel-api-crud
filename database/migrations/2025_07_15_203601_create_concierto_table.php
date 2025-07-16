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
        Schema::create('concierto', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('lugar');
            $table->dateTime('fecha_concierto');
            $table->float('precio_concierto');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('concierto');
    }
};
