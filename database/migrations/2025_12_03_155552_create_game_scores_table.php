<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('game_scores', function (Blueprint $table) {
            $table->id();
            $table->string('level'); // easy, medium, hard
            $table->float('time_seconds'); // lama waktu main
            $table->integer('points');     // poin akhir
            $table->timestamps();          // created_at = waktu main
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_scores');
    }
};
