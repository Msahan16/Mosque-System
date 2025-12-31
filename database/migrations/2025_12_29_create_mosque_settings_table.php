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
        Schema::create('mosque_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->unique()->constrained()->onDelete('cascade');
            $table->decimal('santha_amount', 10, 2)->default(500); // Monthly santha payment amount
            $table->integer('santha_collection_date')->default(25); // Last date to collect (1-31)
            $table->decimal('porridge_amount', 10, 2)->default(0); // Amount per porridge serving
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mosque_settings');
    }
};
