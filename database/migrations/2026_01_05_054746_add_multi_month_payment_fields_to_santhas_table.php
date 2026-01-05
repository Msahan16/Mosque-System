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
        Schema::table('santhas', function (Blueprint $table) {
            // Check and add columns if they don't exist
            if (!Schema::hasColumn('santhas', 'months_covered')) {
                $table->integer('months_covered')->default(1)->after('amount');
            }
            if (!Schema::hasColumn('santhas', 'months_data')) {
                $table->json('months_data')->nullable()->after('months_covered');
            }
            if (!Schema::hasColumn('santhas', 'balance_due')) {
                $table->decimal('balance_due', 10, 2)->default(0)->after('months_data');
            }
            if (!Schema::hasColumn('santhas', 'payment_applies_to')) {
                $table->string('payment_applies_to')->default('current_month')->after('balance_due');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('santhas', function (Blueprint $table) {
            $table->dropColumn(['months_covered', 'months_data', 'balance_due', 'payment_applies_to']);
        });
    }
};
