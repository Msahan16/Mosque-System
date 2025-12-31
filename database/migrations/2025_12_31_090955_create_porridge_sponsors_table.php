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
        Schema::create('porridge_sponsors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->constrained()->onDelete('cascade');
            $table->year('ramadan_year');
            $table->tinyInteger('day_number')->unsigned(); // 1-30
            $table->string('sponsor_name')->nullable(); // Allow anonymous sponsors
            $table->string('sponsor_phone')->nullable();
            $table->enum('sponsor_type', ['individual', 'group'])->default('individual');
            $table->integer('porridge_count')->unsigned()->default(1);
            $table->decimal('amount_per_porridge', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->enum('payment_status', ['pending', 'paid', 'cancelled'])->default('pending');
            $table->enum('payment_method', ['cash', 'online', 'bank_transfer', 'other'])->nullable();
            $table->enum('distribution_status', ['pending', 'distributed', 'cancelled'])->default('pending');
            $table->timestamp('distributed_at')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            // Indexes for better performance
            $table->index(['mosque_id', 'ramadan_year']);
            $table->index(['ramadan_year', 'day_number']);
            $table->unique(['mosque_id', 'ramadan_year', 'day_number', 'sponsor_name'], 'unique_sponsor_per_day');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('porridge_sponsors');
    }
};
