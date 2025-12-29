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
        Schema::create('santhas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->constrained()->onDelete('cascade');
            $table->foreignId('family_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->string('month'); // e.g., "January 2025"
            $table->integer('year');
            $table->date('payment_date');
            $table->string('payment_method')->default('Cash'); // Cash, Bank Transfer, Online
            $table->string('receipt_number')->unique();
            $table->boolean('is_paid')->default(false);
            $table->text('notes')->nullable();
            $table->string('status')->default('pending'); // pending, paid, cancelled
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('santhas');
    }
};
