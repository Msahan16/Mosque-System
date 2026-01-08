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
            $table->foreignId('reference_imam_record_id')
                ->nullable()
                ->constrained('imam_financial_records')
                ->onDelete('cascade')
                ->after('reference_porridge_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('baithulmal_transactions', function (Blueprint $table) {
            $table->dropForeignKey(['reference_imam_record_id']);
            $table->dropColumn('reference_imam_record_id');
        });
    }
};
