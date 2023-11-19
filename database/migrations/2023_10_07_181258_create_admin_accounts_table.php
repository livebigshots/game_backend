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
        Schema::create('admin_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('image')->nullable();
            $table->string('upi_id')->nullable();
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
        Schema::dropIfExists('admin_accounts');
    }
};
