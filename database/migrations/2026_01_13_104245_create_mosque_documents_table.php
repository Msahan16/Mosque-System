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
        Schema::create('mosque_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('reference_no')->nullable();
            $table->date('document_date');
            $table->string('recipient_name');
            $table->text('recipient_address')->nullable();
            $table->string('recipient_id_no')->nullable();
            $table->string('language')->default('en'); // en, si, ta
            $table->longText('content');
            $table->string('template_type')->default('classic'); // classic, modern, sidebar
            $table->json('signatory_ids')->nullable(); // JSON array of board member IDs
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mosque_documents');
    }
};
