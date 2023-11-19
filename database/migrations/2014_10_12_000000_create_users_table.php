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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('role', ['1', '2'])->default('2')->comment('1: Admin |2: User');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('mobile_number')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('image')->nullable();
            $table->string('reference_code')->nullable()->unique();
            $table->enum('status', ['1', '2'])->default('2')->comment('1: Active |2: Deactive');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
