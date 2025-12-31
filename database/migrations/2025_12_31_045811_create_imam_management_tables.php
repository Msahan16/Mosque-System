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
        // Create imams table
        Schema::create('imams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('qualification')->nullable();
            $table->text('experience')->nullable();
            $table->decimal('monthly_salary', 10, 2)->default(0);
            $table->string('status')->default('active'); // active, inactive
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['mosque_id', 'status']);
        });

        // Create imam_available_days table
        Schema::create('imam_available_days', function (Blueprint $table) {
            $table->id();
            $table->foreignId('imam_id')->constrained()->onDelete('cascade');
            $table->foreignId('mosque_id')->constrained()->onDelete('cascade');
            $table->string('day_of_week'); // monday, tuesday, etc.
            $table->boolean('is_available')->default(true);
            $table->date('specific_date')->nullable(); // for one-time availability
            $table->time('start_time')->nullable(); // for time availability
            $table->time('end_time')->nullable(); // for time availability
            $table->date('start_date')->nullable(); // for period availability
            $table->date('end_date')->nullable(); // for period availability
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['imam_id', 'day_of_week']);
            $table->index(['mosque_id', 'specific_date']);
            $table->index(['mosque_id', 'start_date', 'end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imam_available_days');
        Schema::dropIfExists('imams');
    }
};
