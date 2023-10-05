<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sells', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('sand_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('weight');
            $table->unsignedInteger('price');
            $table->unsignedInteger('total');
            $table->integer('paid')->default(0);
            $table->integer('cash')->default(0);
            $table->integer('balance')->default(0);
            $table->timestamp('date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sells');
    }
};
