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
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->nullable()->after('name');
            $table->string('phone')->nullable()->after('email');
            $table->string('country', 2)->nullable()->after('phone');
            $table->string('state')->nullable()->after('country');
            $table->string('referral_code')->nullable()->after('state');
            $table->unsignedBigInteger('referred_by')->nullable()->after('referral_code');
            $table->foreign('referred_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['referred_by']);
            $table->dropColumn(['username', 'phone', 'country', 'state', 'referral_code', 'referred_by']);
        });
    }
};
