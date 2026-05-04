<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->integer('api_id')->unique();
            $table->string('name');
            $table->string('city');
            $table->string('abbreviation', 10);
            $table->string('conference', 10)->nullable();
            $table->string('division')->nullable();
            $table->string('full_name')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};