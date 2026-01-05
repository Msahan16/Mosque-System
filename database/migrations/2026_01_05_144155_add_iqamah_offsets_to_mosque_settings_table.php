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
        Schema::table('mosque_settings', function (Blueprint $table) {
            $table->integer('fajr_iqamah_offset')->default(20)->after('notes');
            $table->integer('dhuhr_iqamah_offset')->default(10)->after('fajr_iqamah_offset');
            $table->integer('asr_iqamah_offset')->default(10)->after('dhuhr_iqamah_offset');
            $table->integer('maghrib_iqamah_offset')->default(5)->after('asr_iqamah_offset');
            $table->integer('isha_iqamah_offset')->default(10)->after('maghrib_iqamah_offset');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mosque_settings', function (Blueprint $table) {
            $table->dropColumn([
                'fajr_iqamah_offset',
                'dhuhr_iqamah_offset',
                'asr_iqamah_offset',
                'maghrib_iqamah_offset',
                'isha_iqamah_offset'
            ]);
        });
    }
};
