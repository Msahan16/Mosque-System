{{-- Donations Report --}}
@php
    $isReceived = ($reportData['transaction_type'] ?? 'received') === 'received';
    $title = $isReceived ? 'Donations Received' : 'Donations Given';
    $icon = $isReceived ? '💰' : '🎁';
    $color = $isReceived ? 'cyan' : 'purple';
@endphp

<div class="space-y-6">
    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-gradient-to-br from-{{ $color }}-500 to-{{ $color }}-600 rounded-2xl shadow-xl p-8 text-white">
            <div class="flex items-center gap-4 mb-4">
                <div class="bg-white/20 p-4 rounded-xl backdrop-blur-sm">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-{{ $color }}-100 text-sm mb-1">Total Amount {{ $isReceived ? 'Received' : 'Given' }}</p>
                    <p class="text-4xl font-bold">LKR {{ number_format($reportData['total_amount'] ?? 0) }}</p>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-xl p-8 text-white">
            <div class="flex items-center gap-4 mb-4">
                <div class="bg-white/20 p-4 rounded-xl backdrop-blur-sm">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-blue-100 text-sm mb-1">Total {{ $title }}</p>
                    <p class="text-4xl font-bold">{{ number_format($reportData['total_count'] ?? 0) }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Donations by Type --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-cyan-600 px-6 py-4">
            <h3 class="text-xl font-bold text-white">{{ $title }} by Type</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($reportData['by_type'] ?? [] as $type => $data)
                    <div class="bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-700 dark:to-slate-600 rounded-xl p-4 border border-slate-200 dark:border-slate-600">
                        <p class="text-sm font-medium text-slate-600 dark:text-slate-300 mb-2">{{ $type }}</p>
                        <p class="text-2xl font-bold text-slate-900 dark:text-white">LKR {{ number_format($data['amount']) }}</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">{{ $data['count'] }} {{ $isReceived ? 'received' : 'given' }}</p>
                    </div>
                @empty
                    <p class="text-slate-500 dark:text-slate-400 col-span-3 text-center py-4">No donation types found</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Top Donors/Recipients --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 px-6 py-4">
            <h3 class="text-xl font-bold text-white">Top {{ $isReceived ? 'Donors' : 'Recipients' }}</h3>
            <p class="text-emerald-100 text-sm mt-1">Highest {{ $isReceived ? 'contributions' : 'distributions' }} this period</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 dark:bg-slate-700/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 dark:text-slate-300 uppercase">Rank</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 dark:text-slate-300 uppercase">{{ $isReceived ? 'Donor' : 'Recipient' }} Name</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 dark:text-slate-300 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 dark:text-slate-300 uppercase">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-700 dark:text-slate-300 uppercase">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($reportData['top_donors'] ?? [] as $index => $donation)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full {{ $index === 0 ? 'bg-yellow-100 text-yellow-700' : ($index === 1 ? 'bg-gray-100 text-gray-700' : ($index === 2 ? 'bg-orange-100 text-orange-700' : 'bg-slate-100 text-slate-700')) }} font-bold text-sm">
                                    {{ $index + 1 }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-900 dark:text-white">{{ $donation->donor_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400">{{ $donation->donation_type }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-emerald-600 dark:text-emerald-400">LKR {{ number_format($donation->amount) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400">{{ \Carbon\Carbon::parse($donation->donation_date)->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                                No {{ $isReceived ? 'donations received' : 'donations given' }} in this period
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
