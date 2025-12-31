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
        Schema::create('imam_financial_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('imam_id')->constrained()->onDelete('cascade');
            $table->foreignId('mosque_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['salary', 'advance']); // Type of financial record

            // Common fields
            $table->decimal('amount', 10, 2); // Total amount for advances, or total salary
            $table->date('record_date'); // salary_month for salaries, request_date for advances
            $table->date('payment_date')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('transaction_id')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default('pending'); // pending, paid, approved, rejected, cancelled

            // Salary-specific fields
            $table->decimal('basic_salary', 10, 2)->nullable();
            $table->decimal('house_allowance', 10, 2)->nullable();
            $table->decimal('transport_allowance', 10, 2)->nullable();
            $table->decimal('medical_allowance', 10, 2)->nullable();
            $table->decimal('other_allowances', 10, 2)->nullable();

            // Advance-specific fields
            $table->string('purpose')->nullable();
            $table->text('reason')->nullable();

            $table->timestamps();

            $table->index(['imam_id', 'type', 'status']);
            $table->index(['mosque_id', 'record_date']);
            $table->index(['type', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imam_financial_records');
    }
};
