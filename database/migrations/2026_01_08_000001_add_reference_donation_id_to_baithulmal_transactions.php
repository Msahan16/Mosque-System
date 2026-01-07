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
        Schema::table('baithulmal_transactions', function (Blueprint $table) {
            $table->foreignId('reference_donation_id')
                ->nullable()
                ->constrained('donations')
                ->onDelete('cascade')
                ->after('reference_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('baithulmal_transactions', function (Blueprint $table) {
            $table->dropForeignIdFor('donations', 'reference_donation_id');
        });
    }
};
