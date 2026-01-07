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
        Schema::create('baithulmal_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->constrained('mosques')->onDelete('cascade');
            $table->enum('type', ['income', 'expense']);
            $table->string('category'); // e.g., 'water_bill', 'electricity_bill', 'jumma_collection', 'donation', etc.
            $table->string('description')->nullable();
            $table->decimal('amount', 15, 2);
            $table->date('transaction_date');
            $table->enum('payment_method', ['cash', 'bank_transfer', 'online', 'cheque', 'other'])->nullable();
            $table->string('reference_number')->nullable(); // For bills, receipts, etc.
            $table->string('paid_to')->nullable(); // For expenses: who received the payment
            $table->string('received_from')->nullable(); // For income: who gave the payment
            $table->text('notes')->nullable();
            $table->string('attachment_path')->nullable(); // For storing bill/receipt images
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            // Indexes for better query performance
            $table->index(['mosque_id', 'type', 'transaction_date']);
            $table->index(['mosque_id', 'category']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baithulmal_transactions');
    }
};
