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
            $table->foreignId('reference_santha_id')
                ->nullable()
                ->constrained('santhas')
                ->onDelete('cascade')
                ->after('reference_donation_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('baithulmal_transactions', function (Blueprint $table) {
            $table->dropForeignIdFor('santhas', 'reference_santha_id');
        });
    }
};
