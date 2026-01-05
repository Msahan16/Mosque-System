<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PrayerSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'mosque_id',
        'date',
        'hijri_date',
        'fajr',
        'sunrise',
        'dhuhr',
        'asr',
        'maghrib',
        'isha',
        'timezone',
        'latitude',
        'longitude',
        'calculation_method',
        'raw_data'
    ];

    protected $casts = [
        'date' => 'date',
        'latitude' => 'float',
        'longitude' => 'float',
        'raw_data' => 'array'
    ];

    public function mosque()
    {
        return $this->belongsTo(Mosque::class);
    }

    public static function fetchPrayerTimes($mosque)
    {
        try {
            // Use Aladhan API to fetch prayer times
            $date = now()->format('d-m-Y');
            $lat = $mosque->latitude ?? '0';
            $lng = $mosque->longitude ?? '0';
            
            $response = \Http::get('https://api.aladhan.com/v1/timings/' . $date, [
                'latitude' => $lat,
                'longitude' => $lng,
                'method' => 8, // ISNA method
                'tune' => '0,0,0,0,0,0,0,0,0'
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $timings = $data['data']['timings'];
                $hijri = $data['data']['hijri'];

                return self::updateOrCreate(
                    ['mosque_id' => $mosque->id, 'date' => now()->toDateString()],
                    [
                        'hijri_date' => "{$hijri['date']['gregorian']} - {$hijri['month']['ar']} {$hijri['year']}",
                        'fajr' => substr($timings['Fajr'], 0, 5),
                        'sunrise' => substr($timings['Sunrise'], 0, 5),
                        'dhuhr' => substr($timings['Dhuhr'], 0, 5),
                        'asr' => substr($timings['Asr'], 0, 5),
                        'maghrib' => substr($timings['Maghrib'], 0, 5),
                        'isha' => substr($timings['Isha'], 0, 5),
                        'timezone' => $mosque->timezone ?? 'UTC',
                        'latitude' => $lat,
                        'longitude' => $lng,
                        'calculation_method' => 'ISNA',
                        'raw_data' => $data['data']
                    ]
                );
            }
        } catch (\Exception $e) {
            \Log::error('Prayer times fetch error: ' . $e->getMessage());
        }

        return null;
    }

    public function getNextPrayerAttribute()
    {
        $now = now();
        $prayers = [
            'Fajr' => $this->fajr,
            'Dhuhr' => $this->dhuhr,
            'Asr' => $this->asr,
            'Maghrib' => $this->maghrib,
            'Isha' => $this->isha,
        ];

        foreach ($prayers as $name => $time) {
            $prayerTime = Carbon::createFromFormat('H:i', $time);
            if ($prayerTime->greaterThan($now)) {
                return ['name' => $name, 'time' => $time];
            }
        }

        return ['name' => 'Fajr (Tomorrow)', 'time' => $this->fajr];
    }

    public function getRemainingTimeAttribute()
    {
        $nextPrayer = $this->next_prayer;
        $now = now();
        $prayerTime = Carbon::createFromFormat('H:i', $nextPrayer['time']);

        if ($prayerTime->lessThan($now)) {
            $prayerTime->addDay();
        }

        $diff = $prayerTime->diff($now);
        return $diff->format('%H:%I:%S');
    }

    /**
     * Get Fajr Iqamah time dynamically
     */
    public function getFajrIqamahAttribute()
    {
        return $this->calculateIqamahTime($this->fajr, 'fajr_iqamah_offset');
    }

    /**
     * Get Dhuhr Iqamah time dynamically
     */
    public function getDhuhrIqamahAttribute()
    {
        return $this->calculateIqamahTime($this->dhuhr, 'dhuhr_iqamah_offset');
    }

    /**
     * Get Asr Iqamah time dynamically
     */
    public function getAsrIqamahAttribute()
    {
        return $this->calculateIqamahTime($this->asr, 'asr_iqamah_offset');
    }

    /**
     * Get Maghrib Iqamah time dynamically
     */
    public function getMaghribIqamahAttribute()
    {
        return $this->calculateIqamahTime($this->maghrib, 'maghrib_iqamah_offset');
    }

    /**
     * Get Isha Iqamah time dynamically
     */
    public function getIshaIqamahAttribute()
    {
        return $this->calculateIqamahTime($this->isha, 'isha_iqamah_offset');
    }

    /**
     * Calculate Iqamah time based on Azan time and mosque settings
     */
    private function calculateIqamahTime($azanTime, $offsetField)
    {
        if (!$azanTime) {
            return null;
        }

        try {
            // Get mosque settings
            $settings = \App\Models\MosqueSetting::where('mosque_id', $this->mosque_id)->first();
            
            // Get offset from settings or use default
            $offset = $settings ? ($settings->$offsetField ?? $this->getDefaultOffset($offsetField)) : $this->getDefaultOffset($offsetField);
            
            // Handle time format - strip seconds if present
            $timeStr = substr($azanTime, 0, 5); // Get only HH:MM
            
            // Calculate Iqamah time
            $time = Carbon::createFromFormat('H:i', $timeStr);
            $time->addMinutes($offset);
            
            return $time->format('H:i');
        } catch (\Exception $e) {
            \Log::warning('Iqamah time calculation error: ' . $e->getMessage(), [
                'azan_time' => $azanTime,
                'offset_field' => $offsetField
            ]);
            return $azanTime; // Fallback to Azan time
        }
    }

    /**
     * Get default offset values
     */
    private function getDefaultOffset($offsetField)
    {
        $defaults = [
            'fajr_iqamah_offset' => 20,
            'dhuhr_iqamah_offset' => 10,
            'asr_iqamah_offset' => 10,
            'maghrib_iqamah_offset' => 5,
            'isha_iqamah_offset' => 10,
        ];

        return $defaults[$offsetField] ?? 10;
    }
}
