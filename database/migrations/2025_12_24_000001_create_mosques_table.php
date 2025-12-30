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
        Schema::create('mosques', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('arabic_name')->nullable();
            $table->text('address');
            $table->string('city')->nullable();
            $table->string('state');
            $table->string('phone');
            $table->string('email')->unique();
            $table->text('description')->nullable();
            $table->string('Head_name')->nullable();
            $table->string('logo')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('status')->default('active'); // active, inactive, closed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mosques');
    }
};
