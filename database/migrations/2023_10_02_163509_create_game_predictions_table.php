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
        Schema::create('game_predictions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('game_type', ['1', '2'])->comment('1: Color Prediction |2: Number Prediction');
            $table->enum('status', ['0', '1', '2'])->default('0')->comment('0:Pending | 1: Running | 2: Complete');
            $table->string('result_color')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_predictions');
    }
};
