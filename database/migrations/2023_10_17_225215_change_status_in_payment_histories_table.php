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
        Schema::table('payment_histories', function (Blueprint $table) {
            $table->enum('status', ['1','2', '3'])->default('1')->comment('1: Pending |2: Verified|3: Decline')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_histories', function (Blueprint $table) {
            $table->enum('status', ['0','1', '2'])->default('0')->comment('1: Pending |2: Verified|3: Decline');
        });
    }
};
