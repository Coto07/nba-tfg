<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->integer('season');
            $table->integer('wins')->default(0);
            $table->integer('losses')->default(0);
            $table->decimal('ppg', 5, 2)->default(0);
            $table->decimal('opp_ppg', 5, 2)->default(0);
            $table->decimal('rpg', 5, 2)->default(0);
            $table->decimal('apg', 5, 2)->default(0);
            $table->decimal('fg_pct', 5, 4)->default(0);
            $table->decimal('fg3_pct', 5, 4)->default(0);
            $table->unique(['team_id', 'season']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_stats');
    }
};