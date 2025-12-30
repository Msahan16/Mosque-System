<?php

namespace App\Livewire\Mosque;

use Livewire\Component;
use App\Models\PrayerSchedule;
use App\Models\Mosque;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class IslamicCalendar extends Component
{
    public $mosque;
    public $currentDate;
    public $selectedDate;
    public $prayerSchedule;
    public $timezone;
    public $hijriDate;
    public $nextPrayer;
    public $remainingTime;
    public $currentTime;
    public $prayerTimes = [];

    public function mount()
    {
        $this->mosque = auth()->user()->mosque ?? Mosque::first();
        $this->timezone = $this->mosque->timezone ?? 'UTC';
        $this->currentDate = now();
        $this->selectedDate = now()->toDateString();
        $this->loadPrayerSchedule();
        $this->getCurrentTime();
    }

    public function loadPrayerSchedule()
    {
        // Try to get prayer schedule from database
        $this->prayerSchedule = PrayerSchedule::where('mosque_id', $this->mosque->id)
            ->where('date', $this->selectedDate)
            ->first();

        // If not found or older than today, fetch from API
        if (!$this->prayerSchedule || $this->selectedDate == now()->toDateString()) {
            $this->fetchPrayerTimesFromAPI();
        }

        if ($this->prayerSchedule) {
            $this->hijriDate = $this->prayerSchedule->hijri_date;
            $this->prayerTimes = [
                'Fajr' => $this->prayerSchedule->fajr,
                'Sunrise' => $this->prayerSchedule->sunrise,
                'Dhuhr' => $this->prayerSchedule->dhuhr,
                'Asr' => $this->prayerSchedule->asr,
                'Maghrib' => $this->prayerSchedule->maghrib,
                'Isha' => $this->prayerSchedule->isha,
            ];
            $this->calculateNextPrayer();
        }
    }

    public function fetchPrayerTimesFromAPI()
    {
        try {
            $dateObj = Carbon::createFromFormat('Y-m-d', $this->selectedDate);
            $date = $dateObj->format('d-m-Y');
            
            // Get mosque coordinates
            $lat = $this->mosque->latitude ?? 0;
            $lng = $this->mosque->longitude ?? 0;

            $response = Http::timeout(10)->get('https://api.aladhan.com/v1/timings/' . $date, [
                'latitude' => $lat,
                'longitude' => $lng,
                'method' => 8, // ISNA method
                'tune' => '0,0,0,0,0,0,0,0,0'
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $timings = $data['data']['timings'];
                $hijri = $data['data']['hijri'];

                $this->prayerSchedule = PrayerSchedule::updateOrCreate(
                    [
                        'mosque_id' => $this->mosque->id,
                        'date' => $this->selectedDate
                    ],
                    [
                        'hijri_date' => "{$hijri['day']} {$hijri['month']['ar']} {$hijri['year']} AH",
                        'fajr' => substr($timings['Fajr'], 0, 5),
                        'sunrise' => substr($timings['Sunrise'], 0, 5),
                        'dhuhr' => substr($timings['Dhuhr'], 0, 5),
                        'asr' => substr($timings['Asr'], 0, 5),
                        'maghrib' => substr($timings['Maghrib'], 0, 5),
                        'isha' => substr($timings['Isha'], 0, 5),
                        'timezone' => $this->timezone,
                        'latitude' => $lat,
                        'longitude' => $lng,
                        'calculation_method' => 'ISNA',
                        'raw_data' => $data['data']
                    ]
                );

                $this->hijriDate = $this->prayerSchedule->hijri_date;
            }
        } catch (\Exception $e) {
            \Log::error('Prayer times fetch error: ' . $e->getMessage());
            $this->dispatch('notify', type: 'error', message: 'Failed to fetch prayer times');
        }
    }

    public function calculateNextPrayer()
    {
        if (!$this->prayerSchedule) return;

        $now = now();
        $prayers = [
            ['name' => 'Fajr', 'time' => $this->prayerSchedule->fajr, 'emoji' => '🌙'],
            ['name' => 'Sunrise', 'time' => $this->prayerSchedule->sunrise, 'emoji' => '🌅'],
            ['name' => 'Dhuhr', 'time' => $this->prayerSchedule->dhuhr, 'emoji' => '☀️'],
            ['name' => 'Asr', 'time' => $this->prayerSchedule->asr, 'emoji' => '🌤️'],
            ['name' => 'Maghrib', 'time' => $this->prayerSchedule->maghrib, 'emoji' => '🌆'],
            ['name' => 'Isha', 'time' => $this->prayerSchedule->isha, 'emoji' => '🌃'],
        ];

        foreach ($prayers as $prayer) {
            $prayerTime = Carbon::createFromFormat('H:i', $prayer['time']);
            if ($prayerTime->greaterThan($now)) {
                $this->nextPrayer = $prayer;
                $this->calculateRemainingTime($prayerTime);
                return;
            }
        }

        // If no prayer found today, next is Fajr tomorrow
        $this->nextPrayer = ['name' => 'Fajr (Tomorrow)', 'time' => $this->prayerSchedule->fajr, 'emoji' => '🌙'];
        $tomorrow = now()->addDay();
        $fajrTime = Carbon::createFromFormat('H:i', $this->prayerSchedule->fajr)->setDate($tomorrow->year, $tomorrow->month, $tomorrow->day);
        $this->calculateRemainingTime($fajrTime);
    }

    public function calculateRemainingTime($prayerTime)
    {
        $now = now();
        $diff = $prayerTime->diff($now);
        $this->remainingTime = sprintf('%02d:%02d:%02d', $diff->h, $diff->i, $diff->s);
    }

    public function getCurrentTime()
    {
        $this->currentTime = now()->format('H:i:s');
    }

    public function changeDate($offset)
    {
        $newDate = Carbon::createFromFormat('Y-m-d', $this->selectedDate)->addDays($offset);
        $this->selectedDate = $newDate->toDateString();
        $this->loadPrayerSchedule();
    }

    public function goToToday()
    {
        $this->selectedDate = now()->toDateString();
        $this->loadPrayerSchedule();
    }

    public function render()
    {
        return view('livewire.mosque.islamic-calendar');
    }
}
