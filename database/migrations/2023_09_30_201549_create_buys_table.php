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
        Schema::create('buys', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('sand_id');
            $table->unsignedInteger('mine_id');
            $table->integer('real_weight');
            $table->integer('mine_weight');
            $table->integer('price');
            $table->integer('total');
            $table->string('car');
            $table->enum('type', ['cash', 'order']);
            $table->timestamp('date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buys');
    }
};
