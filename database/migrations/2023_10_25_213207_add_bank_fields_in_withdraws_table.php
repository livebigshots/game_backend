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
        Schema::table('withdraws', function (Blueprint $table) {
            $table->string('account_number')->after('user_payment_id')->nullable();
            $table->string('bank_mobile_number')->after('account_number')->nullable();
            $table->string('bank_name')->after('bank_mobile_number')->nullable();
            $table->string('ifsc_code')->after('bank_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('withdraws', function (Blueprint $table) {
            $table->dropColumn('account_number');
            $table->dropColumn('bank_mobile_number');
            $table->dropColumn('bank_name');
            $table->dropColumn('ifsc_code');
        });
    }
};
