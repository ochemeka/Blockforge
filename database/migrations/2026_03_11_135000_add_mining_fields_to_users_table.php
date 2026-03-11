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
            $table->decimal('mining_balance', 20, 2)->default(0)->after('referred_by');
            $table->decimal('total_mined', 20, 2)->default(0)->after('mining_balance');
            $table->timestamp('last_mined_at')->nullable()->after('total_mined');
            $table->timestamp('next_mining_available_at')->nullable()->after('last_mined_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['mining_balance', 'total_mined', 'last_mined_at', 'next_mining_available_at']);
        });
    }
};
