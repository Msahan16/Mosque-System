<?php

namespace App\Livewire\Mosque;

use Livewire\Component;
use App\Models\PrayerSchedule;
use App\Models\Mosque;
use App\Models\MosqueSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class IslamicCalendar extends Component
{
    public $mosque;
    public $currentDate;
    public $selectedDate;
    public $prayerSchedule;
    public $timezone = 'Asia/Colombo';
    public $hijriDate;
    public $nextPrayer;
    public $remainingTime;
    public $iqamahRemainingTime;
    public $currentTime;
    public $prayerTimes = [];
    public $country = 'Sri Lanka';
    public $latitude = 6.9271;
    public $longitude = 80.7744;
    public $nextPrayerTime = null;
    public $selectedProvince = 'Colombo';
    public $importantDates = [];
    public $loadingPrayers = true;
    public $apiError = null;
    public $sriLankaProvinces = [
        'Colombo' => ['lat' => 6.9271, 'lng' => 80.7744, 'name' => 'Colombo (Western)'],
        'Kandy' => ['lat' => 6.9271, 'lng' => 80.6386, 'name' => 'Kandy (Central)'],
        'Galle' => ['lat' => 6.0535, 'lng' => 80.2170, 'name' => 'Galle (Southern)'],
        'Jaffna' => ['lat' => 9.6615, 'lng' => 80.7855, 'name' => 'Jaffna (Northern)'],
        'Trincomalee' => ['lat' => 8.5874, 'lng' => 81.2346, 'name' => 'Trincomalee (Eastern)'],
        'Matara' => ['lat' => 5.7489, 'lng' => 80.5375, 'name' => 'Matara (Southern)'],
        'Badulla' => ['lat' => 6.9906, 'lng' => 81.2680, 'name' => 'Badulla (Uva)'],
        'Kurunegala' => ['lat' => 7.4818, 'lng' => 80.6337, 'name' => 'Kurunegala (North Western)'],
        'Anuradhapura' => ['lat' => 8.3154, 'lng' => 80.7691, 'name' => 'Anuradhapura (North Central)'],
        'Ratnapura' => ['lat' => 6.6828, 'lng' => 80.7992, 'name' => 'Ratnapura (Sabaragamuwa)'],
    ];
    
    // Iqamah time offsets (loaded from settings)
    private $fajrOffset = 20;
    private $dhuhrOffset = 10;
    private $asrOffset = 10;
    private $maghribOffset = 5;
    private $ishaOffset = 10;

    public function mount()
    {
        $this->mosque = optional(Auth::user())->mosque ?? Mosque::first();
        
        // Get all values directly from mosque table - no changes allowed
        $this->timezone = $this->mosque->timezone ?? 'Asia/Colombo';
        $this->country = $this->mosque->country ?? 'Sri Lanka';
        $this->latitude = $this->mosque->latitude ?? 6.9271;
        $this->longitude = $this->mosque->longitude ?? 80.7744;
        
        // Find which province this mosque belongs to based on coordinates
        foreach ($this->sriLankaProvinces as $key => $province) {
            if ($province['lat'] == $this->latitude && $province['lng'] == $this->longitude) {
                $this->selectedProvince = $key;
                break;
            }
        }
        
        $this->currentDate = now($this->timezone);
        $this->selectedDate = now($this->timezone)->toDateString();
        
        // Clear old default/fake prayer times from database
        PrayerSchedule::where('mosque_id', $this->mosque->id)
            ->where('calculation_method', 'DEFAULT')
            ->delete();
        
        $this->loadPrayerSchedule();
        $this->getCurrentTime();
        
        // Load important dates asynchronously to avoid blocking page load
        $this->loadImportantDates();
        
        // Load Iqamah offsets from mosque settings
        $this->loadIqamahOffsets();
    }

    /**
     * Load Iqamah time offsets from mosque settings
     */
    private function loadIqamahOffsets()
    {
        $settings = MosqueSetting::where('mosque_id', $this->mosque->id)->first();
        
        if ($settings) {
            $this->fajrOffset = $settings->fajr_iqamah_offset ?? 20;
            $this->dhuhrOffset = $settings->dhuhr_iqamah_offset ?? 10;
            $this->asrOffset = $settings->asr_iqamah_offset ?? 10;
            $this->maghribOffset = $settings->maghrib_iqamah_offset ?? 5;
            $this->ishaOffset = $settings->isha_iqamah_offset ?? 10;
        } else {
            // Default values if no settings found
            $this->fajrOffset = 20;
            $this->dhuhrOffset = 10;
            $this->asrOffset = 10;
            $this->maghribOffset = 5;
            $this->ishaOffset = 10;
        }
    }

    public function updateProvinceLocation()
    {
        // Do nothing - provinces cannot be changed
        // All data comes from the mosque table
    }

    public function loadPrayerSchedule()
    {
        $this->loadingPrayers = true;
        $this->apiError = null;
        
        // Verify mosque data is loaded
        if (!$this->mosque || !$this->latitude || !$this->longitude) {
            $this->loadingPrayers = false;
            $this->apiError = 'Mosque data not found. Please check mosque settings.';
            return;
        }
        
        // Always fetch fresh prayer times from API
        $apiSuccess = $this->fetchPrayerTimesFromAPI();

        // If API call failed, try to get from database
        if (!$apiSuccess && !$this->prayerSchedule) {
            $this->prayerSchedule = PrayerSchedule::where('mosque_id', $this->mosque->id)
                ->where('date', $this->selectedDate)
                ->where('calculation_method', '!=', 'DEFAULT') // Exclude default/fake records
                ->latest('created_at')
                ->first();
        }

        // If still no schedule, show error with retry
        if (!$this->prayerSchedule) {
            $this->loadingPrayers = false;
            $this->apiError = 'Unable to load prayer times. Please check your internet connection and try again.';
            Log::error('Failed to load prayer times from API and database', [
                'mosque_id' => $this->mosque->id,
                'date' => $this->selectedDate,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'api_success' => $apiSuccess
            ]);
            return;
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
            $this->loadImportantDates(); // Load important dates now that hijri date is set
            $this->loadingPrayers = false;
            $this->apiError = null;
        }
    }

    public function retryLoadPrayers()
    {
        $this->loadPrayerSchedule();
    }

    public function fetchPrayerTimesFromAPI()
    {
        try {
            $dateObj = Carbon::createFromFormat('Y-m-d', $this->selectedDate);
            $date = $dateObj->format('d-m-Y');
            
            // Use current component latitude/longitude (updated by province selection)
            $lat = $this->latitude;
            $lng = $this->longitude;

            Log::info("Fetching prayer times for {$this->selectedDate}", [
                'date' => $date,
                'latitude' => $lat,
                'longitude' => $lng,
                'province' => $this->selectedProvince
            ]);

            $response = Http::timeout(15)->withoutVerifying()->get('https://api.aladhan.com/v1/timings/' . $date, [
                'latitude' => $lat,
                'longitude' => $lng,
                'method' => 5, // Egyptian General Authority of Survey (standard for Sri Lanka)
                'tune' => '0,4,0,-1,-1,0,0,-1,0' // Custom adjustments: Fajr+4, Dhuhr-1, Asr-1, Isha-1
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (!isset($data['data']['timings'])) {
                    throw new \Exception('Invalid API response format');
                }

                $timings = $data['data']['timings'];
                $hijri = $data['data']['date']['hijri']; // Fixed: hijri is nested under date

                Log::info("Prayer times fetched successfully", [
                    'fajr' => substr($timings['Fajr'], 0, 5),
                    'dhuhr' => substr($timings['Dhuhr'], 0, 5),
                    'hijri' => "{$hijri['day']} {$hijri['month']['en']} {$hijri['year']}"
                ]);

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
                        'timezone' => 'Asia/Colombo',
                        'latitude' => $lat,
                        'longitude' => $lng,
                        'calculation_method' => 'Karachi Method (Sri Lanka)',
                        'raw_data' => json_encode($data['data'])
                    ]
                );

                $this->hijriDate = $this->prayerSchedule->hijri_date;
                
                return true;
            } else {
                throw new \Exception('API returned status: ' . $response->status());
            }
        } catch (\Exception $e) {
            Log::error('Prayer times fetch error: ' . $e->getMessage(), [
                'date' => $this->selectedDate,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude
            ]);
            
            return false;
        }
    }

    public function calculateNextPrayer()
    {
        if (!$this->prayerSchedule) return;

        $now = now($this->timezone);
        $prayers = [
            ['name' => 'Fajr', 'time' => trim($this->prayerSchedule->fajr ?? ''), 'emoji' => '🌙'],
            ['name' => 'Sunrise', 'time' => trim($this->prayerSchedule->sunrise ?? ''), 'emoji' => '🌅'],
            ['name' => 'Dhuhr', 'time' => trim($this->prayerSchedule->dhuhr ?? ''), 'emoji' => '☀️'],
            ['name' => 'Asr', 'time' => trim($this->prayerSchedule->asr ?? ''), 'emoji' => '🌤️'],
            ['name' => 'Maghrib', 'time' => trim($this->prayerSchedule->maghrib ?? ''), 'emoji' => '🌆'],
            ['name' => 'Isha', 'time' => trim($this->prayerSchedule->isha ?? ''), 'emoji' => '🌃'],
        ];

        foreach ($prayers as $prayer) {
            try {
                if (empty($prayer['time'])) continue;
                
                // Extract only HH:MM format
                $timeStr = preg_replace('/[^0-9:]/', '', $prayer['time']);
                if (strlen($timeStr) < 5) {
                    continue;
                }
                $timeStr = substr($timeStr, 0, 5); // Get only HH:MM
                
                $prayerTime = Carbon::createFromFormat('H:i', $timeStr, $this->timezone)->setDate($now->year, $now->month, $now->day);
                
                if ($prayerTime->greaterThan($now)) {
                    // Get Iqamah time for this prayer (skip Sunrise as it has no Iqamah)
                    $iqamahTime = null;
                    if ($prayer['name'] !== 'Sunrise') {
                        $iqamahField = strtolower($prayer['name']) . '_iqamah';
                        $iqamahTime = $this->prayerSchedule->$iqamahField ?? null;
                    }
                    
                    $this->nextPrayer = array_merge($prayer, [
                        'iqamah_time' => $iqamahTime
                    ]);
                    $this->nextPrayerTime = $prayerTime;
                    $this->updateRemainingTime();
                    return;
                }
            } catch (\Exception $e) {
                Log::warning('Prayer time parse error for ' . $prayer['name'] . ': ' . $prayer['time']);
                continue;
            }
        }

        // If no prayer found today, next is Fajr tomorrow
        if (!empty($this->prayerSchedule->fajr)) {
            $fajrIqamah = $this->prayerSchedule->fajr_iqamah ?? null;
            
            $this->nextPrayer = [
                'name' => 'Fajr (Tomorrow)', 
                'time' => trim($this->prayerSchedule->fajr), 
                'emoji' => '🌙',
                'iqamah_time' => $fajrIqamah
            ];
            $tomorrow = now($this->timezone)->addDay();
            
            try {
                $timeStr = preg_replace('/[^0-9:]/', '', $this->prayerSchedule->fajr);
                $timeStr = substr($timeStr, 0, 5);
                $fajrTime = Carbon::createFromFormat('H:i', $timeStr, $this->timezone)->setDate($tomorrow->year, $tomorrow->month, $tomorrow->day);
                $this->nextPrayerTime = $fajrTime;
                $this->updateRemainingTime();
            } catch (\Exception $e) {
                $this->remainingTime = '00:00:00';
                $this->iqamahRemainingTime = '00:00:00';
            }
        }
    }

    public function updateRemainingTime()
    {
        if (!$this->nextPrayerTime) {
            $this->remainingTime = '00:00:00';
            $this->iqamahRemainingTime = '00:00:00';
            return;
        }
        
        try {
            $now = now($this->timezone);
            
            // Calculate remaining time until Azan
            $diff = $this->nextPrayerTime->diff($now);
            $this->remainingTime = sprintf('%02d:%02d:%02d', $diff->h, $diff->i, $diff->s);
            
            // Calculate remaining time until Iqamah (if exists)
            if (isset($this->nextPrayer['iqamah_time']) && $this->nextPrayer['iqamah_time']) {
                try {
                    $iqamahTimeStr = substr($this->nextPrayer['iqamah_time'], 0, 5);
                    $iqamahTime = Carbon::createFromFormat('H:i', $iqamahTimeStr, $this->timezone)
                        ->setDate($now->year, $now->month, $now->day);
                    
                    // If Iqamah time has passed today, it must be tomorrow
                    if ($iqamahTime->lessThan($now)) {
                        $iqamahTime->addDay();
                    }
                    
                    $iqamahDiff = $iqamahTime->diff($now);
                    $this->iqamahRemainingTime = sprintf('%02d:%02d:%02d', $iqamahDiff->h, $iqamahDiff->i, $iqamahDiff->s);
                } catch (\Exception $e) {
                    $this->iqamahRemainingTime = '00:00:00';
                }
            } else {
                $this->iqamahRemainingTime = '00:00:00';
            }
        } catch (\Exception $e) {
            $this->remainingTime = '00:00:00';
            $this->iqamahRemainingTime = '00:00:00';
        }
    }

    public function getCurrentTime()
    {
        $this->currentTime = now($this->timezone)->format('H:i:s');
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

    public function loadImportantDates()
    {
        // Wait for prayer schedule to be loaded first
        if (!$this->prayerSchedule || !$this->prayerSchedule->hijri_date) {
            // If prayer schedule not loaded yet, we'll load important dates after prayer schedule loads
            // Get default Hijri year for caching
            $cacheKey = 'islamic_dates_1447_default';
        } else {
            $cacheKey = 'islamic_dates_' . $this->prayerSchedule->hijri_date;
        }
        
        $this->importantDates = cache()->remember($cacheKey, 60 * 60 * 24 * 7, function () {
            return $this->getImportantIslamicDates();
        });
    }

    public function render()
    {
        return view('livewire.mosque.islamic-calendar');
    }

    private function getImportantIslamicDates()
    {
        // Get current Hijri year from prayer schedule
        $currentHijriYear = 1447; // Default fallback for 2025-2026
        
        try {
            if ($this->prayerSchedule && $this->prayerSchedule->hijri_date) {
                // Extract year from hijri_date string (format: "DD Month YYYY AH")
                preg_match('/(\d{4})/', $this->prayerSchedule->hijri_date, $matches);
                if (isset($matches[1])) {
                    $currentHijriYear = (int)$matches[1];
                }
            }
        } catch (\Exception $e) {
            Log::warning('Could not extract Hijri year: ' . $e->getMessage());
        }

        // Important Islamic dates with Hijri date format (DD-MM-YYYY)
        $islamicDates = [
            ['hijri' => '01-01-' . $currentHijriYear, 'event' => 'Islamic New Year (Hijri New Year)', 'emoji' => '🌙', 'color' => 'blue'],
            ['hijri' => '10-01-' . $currentHijriYear, 'event' => 'Day of Ashura', 'emoji' => '🕌', 'color' => 'purple'],
            ['hijri' => '12-03-' . $currentHijriYear, 'event' => 'Mawlid al-Nabi (Prophet Muhammad\'s Birthday)', 'emoji' => '✨', 'color' => 'green'],
            ['hijri' => '27-07-' . $currentHijriYear, 'event' => 'Isra and Mi\'raj Night', 'emoji' => '🌠', 'color' => 'indigo'],
            ['hijri' => '01-09-' . $currentHijriYear, 'event' => 'First Day of Ramadan', 'emoji' => '🌙', 'color' => 'blue'],
            ['hijri' => '27-09-' . $currentHijriYear, 'event' => 'Laylat al-Qadr (Night of Power)', 'emoji' => '✨', 'color' => 'yellow'],
            ['hijri' => '01-10-' . $currentHijriYear, 'event' => 'Eid al-Fitr', 'emoji' => '🎉', 'color' => 'green'],
            ['hijri' => '09-12-' . $currentHijriYear, 'event' => 'Day of Arafah', 'emoji' => '🕌', 'color' => 'teal'],
            ['hijri' => '10-12-' . $currentHijriYear, 'event' => 'Eid al-Adha', 'emoji' => '🐑', 'color' => 'red'],
        ];

        // Convert each Hijri date to Gregorian using Aladhan API
        $convertedDates = [];
        foreach ($islamicDates as $event) {
            try {
                // API endpoint: https://api.aladhan.com/v1/hToG/dd-mm-yyyy
                $response = Http::timeout(5)->withoutVerifying()->get('https://api.aladhan.com/v1/hToG/' . $event['hijri']);
                
                if ($response->successful()) {
                    $data = $response->json();
                    
                    if (isset($data['code']) && $data['code'] == 200 && isset($data['data']['gregorian'])) {
                        $greg = $data['data']['gregorian'];
                        $gregorianDate = $greg['day'] . ' ' . $greg['month']['en'] . ' ' . $greg['year'];
                        
                        $convertedDates[] = [
                            'date' => $gregorianDate,
                            'event' => $event['event'],
                            'emoji' => $event['emoji'],
                            'color' => $event['color'],
                            'hijri' => $event['hijri']
                        ];
                    } else {
                        // Fallback if conversion fails
                        $convertedDates[] = [
                            'date' => 'Date TBD',
                            'event' => $event['event'],
                            'emoji' => $event['emoji'],
                            'color' => $event['color'],
                            'hijri' => $event['hijri']
                        ];
                    }
                } else {
                    // Fallback for failed API call
                    $convertedDates[] = [
                        'date' => 'Date TBD',
                        'event' => $event['event'],
                        'emoji' => $event['emoji'],
                        'color' => $event['color'],
                        'hijri' => $event['hijri']
                    ];
                }
                
                // Small delay to avoid rate limiting
                usleep(100000); // 0.1 second delay
                
            } catch (\Exception $e) {
                Log::warning('Date conversion error for ' . $event['hijri'] . ': ' . $e->getMessage());
                
                // Fallback dates
                $convertedDates[] = [
                    'date' => 'Date TBD',
                    'event' => $event['event'],
                    'emoji' => $event['emoji'],
                    'color' => $event['color'],
                    'hijri' => $event['hijri']
                ];
            }
        }

        return $convertedDates;
    }

    /**
     * Calculate Iqamah time by adding minutes to Azan time
     * 
     * @param string $azanTime Time in HH:MM format
     * @param int $minutesToAdd Minutes to add for Iqamah
     * @return string Iqamah time in HH:MM format
     */
    private function calculateIqamahTime($azanTime, $minutesToAdd)
    {
        try {
            $time = Carbon::createFromFormat('H:i', $azanTime, $this->timezone);
            $time->addMinutes($minutesToAdd);
            return $time->format('H:i');
        } catch (\Exception $e) {
            Log::warning('Iqamah time calculation error: ' . $e->getMessage());
            return $azanTime; // Fallback to Azan time if calculation fails
        }
    }
}
