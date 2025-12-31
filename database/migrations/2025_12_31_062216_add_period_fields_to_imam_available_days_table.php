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
        Schema::table('imam_available_days', function (Blueprint $table) {
            $table->date('start_date')->nullable()->after('specific_date');
            $table->date('end_date')->nullable()->after('start_date');
            $table->index(['mosque_id', 'start_date', 'end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('imam_available_days', function (Blueprint $table) {
            $table->dropIndex(['mosque_id', 'start_date', 'end_date']);
            $table->dropColumn(['start_date', 'end_date']);
        });
    }
};
