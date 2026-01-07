<?php

namespace App\Livewire\Mosque;

use App\Models\Family;
use App\Models\Donation;
use App\Models\Santha;
use App\Models\Student;
use App\Models\Ustad;
use App\Models\ImamFinancialRecord;
use App\Models\PorridgeSponsor;
use App\Models\BaithulmalTransaction;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Carbon\Carbon;

#[Layout('components.layouts.app')]
class Reports extends Component
{
    public $reportType = 'overview';
    public $startDate;
    public $endDate;
    public $mosqueName;
    
    // Report data
    public $reportData = [];

    public function mount()
    {
        $user = auth()->user();
        $this->mosqueName = $user->mosque->name ?? 'Mosque';
        
        // Set default date range (current month)
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
        
        $this->generateReport();
    }

    public function updatedReportType()
    {
        $this->generateReport();
    }

    public function updatedStartDate()
    {
        $this->generateReport();
    }

    public function updatedEndDate()
    {
        $this->generateReport();
    }

    public function generateReport()
    {
        $user = auth()->user();
        $mosqueId = $user->mosque_id;
        
        $start = Carbon::parse($this->startDate);
        $end = Carbon::parse($this->endDate);

        switch ($this->reportType) {
            case 'overview':
                $this->reportData = $this->getOverviewReport($mosqueId, $start, $end);
                break;
            case 'families':
                $this->reportData = $this->getFamiliesReport($mosqueId, $start, $end);
                break;
            case 'donations-received':
                $this->reportData = $this->getDonationsReport($mosqueId, $start, $end, 'received');
                break;
            case 'donations-given':
                $this->reportData = $this->getDonationsReport($mosqueId, $start, $end, 'given');
                break;
            case 'santhas':
                $this->reportData = $this->getSanthasReport($mosqueId, $start, $end);
                break;
            case 'madrasa':
                $this->reportData = $this->getMadrasaReport($mosqueId, $start, $end);
                break;
            case 'imam':
                $this->reportData = $this->getImamReport($mosqueId, $start, $end);
                break;
            case 'porridge':
                $this->reportData = $this->getPorridgeReport($mosqueId, $start, $end);
                break;
            case 'baithulmal':
                $this->reportData = $this->getBaithulmalReport($mosqueId, $start, $end);
                break;
            case 'financial':
                $this->reportData = $this->getFinancialReport($mosqueId, $start, $end);
                break;
        }
    }

    private function getOverviewReport($mosqueId, $start, $end)
    {
        return [
            'total_families' => Family::where('mosque_id', $mosqueId)->count(),
            'total_members' => Family::where('mosque_id', $mosqueId)->sum('total_members'),
            'new_families' => Family::where('mosque_id', $mosqueId)
                ->whereBetween('created_at', [$start, $end])
                ->count(),
            'total_donations' => Donation::where('mosque_id', $mosqueId)
                ->whereBetween('donation_date', [$start, $end])
                ->sum('amount'),
            'total_santhas_paid' => Santha::where('mosque_id', $mosqueId)
                ->whereBetween('payment_date', [$start, $end])
                ->where('is_paid', true)
                ->sum('amount'),
            'total_students' => Student::where('mosque_id', $mosqueId)->count(),
            'active_ustads' => Ustad::where('mosque_id', $mosqueId)->where('is_active', true)->count(),
        ];
    }

    private function getFamiliesReport($mosqueId, $start, $end)
    {
        $families = Family::where('mosque_id', $mosqueId)
            ->whereBetween('created_at', [$start, $end])
            ->get();

        return [
            'total' => Family::where('mosque_id', $mosqueId)->count(),
            'new_registrations' => $families->count(),
            'total_members' => Family::where('mosque_id', $mosqueId)->sum('total_members'),
            'families_list' => $families,
            'by_month' => $families->groupBy(function($family) {
                return Carbon::parse($family->created_at)->format('Y-m');
            })->map->count(),
        ];
    }

    private function getDonationsReport($mosqueId, $start, $end, $transactionType = 'received')
    {
        $donations = Donation::where('mosque_id', $mosqueId)
            ->where('transaction_type', $transactionType)
            ->whereBetween('donation_date', [$start, $end])
            ->get();

        return [
            'transaction_type' => $transactionType,
            'total_amount' => $donations->sum('amount'),
            'total_count' => $donations->count(),
            'by_type' => $donations->groupBy('donation_type')->map(function($group) {
                return [
                    'count' => $group->count(),
                    'amount' => $group->sum('amount')
                ];
            }),
            'top_donors' => $donations->sortByDesc('amount')->take(10),
            'donations_list' => $donations,
            'by_month' => $donations->groupBy(function($donation) {
                return Carbon::parse($donation->donation_date)->format('Y-m');
            })->map->sum('amount'),
        ];
    }

    private function getSanthasReport($mosqueId, $start, $end)
    {
        $santhas = Santha::where('mosque_id', $mosqueId)
            ->whereBetween('payment_date', [$start, $end])
            ->get();

        $unpaidSanthas = Santha::where('mosque_id', $mosqueId)
            ->where('is_paid', false)
            ->get();

        return [
            'total_paid' => $santhas->where('is_paid', true)->sum('amount'),
            'total_unpaid' => $unpaidSanthas->sum('amount'),
            'paid_count' => $santhas->where('is_paid', true)->count(),
            'unpaid_count' => $unpaidSanthas->count(),
            'paid_list' => $santhas->where('is_paid', true),
            'unpaid_list' => $unpaidSanthas,
            'by_month' => $santhas->where('is_paid', true)->groupBy(function($santha) {
                return $santha->month . ' ' . $santha->year;
            })->map->sum('amount'),
        ];
    }

    private function getMadrasaReport($mosqueId, $start, $end)
    {
        $students = Student::where('mosque_id', $mosqueId)->get();
        $ustads = Ustad::where('mosque_id', $mosqueId)->get();

        return [
            'total_students' => $students->count(),
            'active_students' => $students->where('is_active', true)->count(),
            'total_ustads' => $ustads->count(),
            'active_ustads' => $ustads->where('is_active', true)->count(),
            'students_by_class' => $students->groupBy('class_level')->map->count(),
            'students_list' => $students,
            'ustads_list' => $ustads,
        ];
    }

    private function getImamReport($mosqueId, $start, $end)
    {
        $financials = ImamFinancialRecord::where('mosque_id', $mosqueId)
            ->whereBetween('record_date', [$start, $end])
            ->get();

        return [
            'total_schedules' => 0, // Schedules not implemented
            'total_payments' => $financials->where('type', 'salary')->sum('amount'),
            'total_advances' => $financials->where('type', 'advance')->sum('amount'),
            'financials_list' => $financials,
            'by_type' => $financials->groupBy('type')->map->count(),
        ];
    }

    private function getPorridgeReport($mosqueId, $start, $end)
    {
        // Get the year range from start and end dates
        $startYear = $start->year;
        $endYear = $end->year;
        
        $sponsors = PorridgeSponsor::where('mosque_id', $mosqueId)
            ->whereBetween('ramadan_year', [$startYear, $endYear])
            ->get();

        return [
            'total_sponsors' => $sponsors->count(),
            'total_amount' => $sponsors->sum('total_amount'),
            'days_covered' => $sponsors->pluck('day_number')->unique()->count(),
            'sponsors_list' => $sponsors,
            'by_year' => $sponsors->groupBy('ramadan_year')->map->count(),
        ];
    }

    private function getBaithulmalReport($mosqueId, $start, $end)
    {
        $transactions = BaithulmalTransaction::where('mosque_id', $mosqueId)
            ->whereBetween('transaction_date', [$start, $end])
            ->get();

        $income = $transactions->where('type', 'income');
        $expense = $transactions->where('type', 'expense');

        return [
            'total_income' => $income->sum('amount'),
            'total_expense' => $expense->sum('amount'),
            'net_balance' => $income->sum('amount') - $expense->sum('amount'),
            'income_count' => $income->count(),
            'expense_count' => $expense->count(),
            'income_by_category' => $income->groupBy('category')->map(function($group) {
                return [
                    'count' => $group->count(),
                    'amount' => $group->sum('amount')
                ];
            }),
            'expense_by_category' => $expense->groupBy('category')->map(function($group) {
                return [
                    'count' => $group->count(),
                    'amount' => $group->sum('amount')
                ];
            }),
            'transactions_list' => $transactions,
            'by_month' => $transactions->groupBy(function($transaction) {
                return Carbon::parse($transaction->transaction_date)->format('Y-m');
            })->map(function($group) {
                return [
                    'income' => $group->where('type', 'income')->sum('amount'),
                    'expense' => $group->where('type', 'expense')->sum('amount'),
                ];
            }),
        ];
    }

    private function getFinancialReport($mosqueId, $start, $end)
    {
        $donations = Donation::where('mosque_id', $mosqueId)
            ->whereBetween('donation_date', [$start, $end])
            ->sum('amount');

        $santhas = Santha::where('mosque_id', $mosqueId)
            ->whereBetween('payment_date', [$start, $end])
            ->where('is_paid', true)
            ->sum('amount');

        // Get the year range from start and end dates for porridge
        $startYear = $start->year;
        $endYear = $end->year;
        
        $porridge = PorridgeSponsor::where('mosque_id', $mosqueId)
            ->whereBetween('ramadan_year', [$startYear, $endYear])
            ->sum('total_amount');

        $imamExpenses = ImamFinancialRecord::where('mosque_id', $mosqueId)
            ->whereBetween('record_date', [$start, $end])
            ->sum('amount');

        $totalIncome = $donations + $santhas + $porridge;
        $totalExpenses = $imamExpenses;

        return [
            'total_income' => $totalIncome,
            'total_expenses' => $totalExpenses,
            'net_balance' => $totalIncome - $totalExpenses,
            'income_breakdown' => [
                'donations' => $donations,
                'santhas' => $santhas,
                'porridge' => $porridge,
            ],
            'expense_breakdown' => [
                'imam' => $imamExpenses,
            ],
        ];
    }

    public function render()
    {
        return view('livewire.mosque.reports');
    }
}
