<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('player_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->constrained()->cascadeOnDelete();
            $table->integer('season');
            $table->integer('games_played')->default(0);
            $table->decimal('pts', 5, 2)->default(0);
            $table->decimal('reb', 5, 2)->default(0);
            $table->decimal('ast', 5, 2)->default(0);
            $table->decimal('stl', 5, 2)->default(0);
            $table->decimal('blk', 5, 2)->default(0);
            $table->decimal('fg_pct', 5, 4)->default(0);
            $table->decimal('fg3_pct', 5, 4)->default(0);
            $table->decimal('ft_pct', 5, 4)->default(0);
            $table->decimal('min', 5, 2)->default(0);
            $table->decimal('turnover', 5, 2)->default(0);
            $table->unique(['player_id', 'season']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('player_stats');
    }
};