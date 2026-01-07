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
            $table->foreignId('reference_porridge_id')
                ->nullable()
                ->constrained('porridge_sponsors')
                ->onDelete('cascade')
                ->after('reference_santha_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('baithulmal_transactions', function (Blueprint $table) {
            $table->dropForeignIdFor('porridge_sponsors', 'reference_porridge_id');
        });
    }
};
