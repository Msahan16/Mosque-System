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
        Schema::create('families', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->constrained()->onDelete('cascade');
            $table->string('family_head_name');
            $table->string('family_head_profession')->nullable();
            $table->string('phone');
            $table->string('email')->nullable();
            $table->text('address');
            $table->integer('total_members')->default(1);
            $table->date('registration_date');
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->decimal('family_income', 12, 2)->nullable();
            $table->string('status')->default('active'); // active, inactive, moved
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('families');
    }
};
