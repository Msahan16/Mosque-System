@section('title', 'Santha Collection')

<div class="py-6 min-h-screen">
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-white">Santha Collection</h2>
                <p class="text-white/80 mt-1 text-sm">Monthly membership payments - {{ $currentMonthName }}</p>
            </div>
            <button wire:click="openModal" class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-green-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-green-700 transition shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Record Payment
            </button>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-xl p-4 shadow-lg">
                <p class="text-blue-100 text-xs font-medium">This Month</p>
                <p class="text-2xl font-bold mt-1">LKR {{ number_format($totalCollectedThisMonth, 0) }}</p>
            </div>
            <div class="bg-gradient-to-br from-green-500 to-emerald-500 text-white rounded-xl p-4 shadow-lg">
                <p class="text-green-100 text-xs font-medium">Paid</p>
                <p class="text-2xl font-bold mt-1">{{ $paidThisMonth }} / {{ $totalFamilies }}</p>
            </div>
            <div class="bg-gradient-to-br from-orange-500 to-orange-600 text-white rounded-xl p-4 shadow-lg">
                <p class="text-orange-100 text-xs font-medium">Pending</p>
                <p class="text-2xl font-bold mt-1">{{ $pendingThisMonth }}</p>
            </div>
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-xl p-4 shadow-lg">
                <p class="text-purple-100 text-xs font-medium">Rate</p>
                <p class="text-2xl font-bold mt-1">{{ $collectionRate }}%</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <select wire:model.live="filterMonth" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-sm">
                    <option value="">All Months</option>
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}">{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <select wire:model.live="filterYear" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-sm">
                    @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <input wire:model.live="search" type="text" placeholder="Search family or receipt..." 
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-sm">
            </div>
        </div>

        <!-- Payments Table -->
        <div class="content-overlay rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gradient-to-r from-blue-50 to-green-50 dark:from-blue-900/30 dark:to-green-900/30">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Receipt</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Family</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Period</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Amount</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Date</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($santhas as $santha)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                <td class="px-4 py-3">
                                    <span class="text-xs font-mono text-blue-600 dark:text-blue-400">{{ $santha->receipt_number }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $santha->family->family_head_name ?? 'N/A' }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-sm text-gray-900 dark:text-white">{{ $santha->month }} {{ $santha->year }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-sm font-semibold text-green-600 dark:text-green-400">LKR {{ number_format($santha->amount, 0) }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $santha->payment_date->format('d M Y') }}</span>
                                </td>
                                <td class="px-4 py-3 text-center space-x-1">
                                    <button wire:click="viewReceipt({{ $santha->id }})" class="px-2 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700">View</button>
                                    <button wire:click="editSantha({{ $santha->id }})" class="px-2 py-1 bg-purple-600 text-white text-xs rounded hover:bg-purple-700">Edit</button>
                                    <button onclick="confirmDelete('confirmDeleteSantha', {{ $santha->id }}, 'Delete Payment?', 'This action cannot be undone.')" class="px-2 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700">Delete</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-12 text-center">
                                    <p class="text-gray-500 dark:text-gray-400">No payments found</p>
                                    <p class="text-gray-400 dark:text-gray-500 text-sm mt-1">Click "Record Payment" to add one</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($santhas->hasPages())
                <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
                    {{ $santhas->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Add/Edit Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4" wire:click.self="closeModal">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-md w-full">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-blue-600 to-green-600 text-white px-5 py-3 rounded-t-xl">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold">{{ $editMode ? 'Edit Payment' : 'Record Payment' }}</h3>
                        <button wire:click="closeModal" class="text-white hover:text-gray-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="p-5">
                    <form wire:submit.prevent="saveSantha" class="space-y-4">
                        <!-- Family Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Family *</label>
                            <select wire:model.live="family_id" required class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
                                <option value="">Select Family</option>
                                @foreach($families as $family)
                                    <option value="{{ $family->id }}">{{ $family->family_head_name }}</option>
                                @endforeach
                            </select>
                            @error('family_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Month & Year -->
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Month *</label>
                                <select wire:model="month" required class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
                                    @for($m = 1; $m <= 12; $m++)
                                        <option value="{{ $m }}">{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                                    @endfor
                                </select>
                                @error('month') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Year *</label>
                                <select wire:model="year" required class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
                                    @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                                        <option value="{{ $y }}">{{ $y }}</option>
                                    @endfor
                                </select>
                                @error('year') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Amount -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Amount (LKR) *</label>
                            <input wire:model="amount" type="number" step="0.01" required class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
                            @error('amount') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Payment Date & Method -->
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Payment Date *</label>
                                <input wire:model="payment_date" type="date" required class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
                                @error('payment_date') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Method *</label>
                                <select wire:model="payment_method" required class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
                                    <option value="cash">Cash</option>
                                    <option value="online">Online</option>
                                    <option value="check">Check</option>
                                </select>
                                @error('payment_method') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Notes -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Notes</label>
                            <textarea wire:model="notes" rows="2" placeholder="Optional notes..." class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white"></textarea>
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-3 pt-2">
                            <button type="button" wire:click="closeModal" class="flex-1 px-4 py-2 bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-400 font-medium">
                                Cancel
                            </button>
                            <button type="submit" class="flex-1 px-4 py-2 bg-gradient-to-r from-blue-600 to-green-600 text-white rounded-lg hover:from-blue-700 hover:to-green-700 font-medium shadow-lg">
                                {{ $editMode ? 'Update' : 'Save Payment' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Receipt Modal -->
    @if($showReceiptModal && $viewingSantha)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-4">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-lg font-bold text-gray-900">Receipt</h3>
                    <div class="space-x-2">
                        <button onclick="printSanthaReceipt()" class="px-3 py-1 bg-blue-600 text-white rounded text-xs">Print</button>
                        <button onclick="downloadSanthaReceipt()" class="px-3 py-1 bg-green-600 text-white rounded text-xs">Download</button>
                        <button wire:click="closeReceiptModal" class="px-3 py-1 bg-gray-300 text-gray-800 rounded text-xs">Close</button>
                    </div>
                </div>

                <div id="santha-receipt-content" style="background:#ffffff;padding:22px;color:#111827;font-family:Inter, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;max-width:640px;margin:0 auto;">
                    <div style="text-align:center;margin-bottom:8px;">
                        <h2 style="font-size:20px;margin:0 0 4px 0;font-weight:700;color:#0f172a;">{{ $viewingSantha['mosque_name'] }}</h2>
                        <p style="margin:0;color:#6b7280;font-size:13px;">Santha Payment Receipt</p>
                    </div>

                    <table style="width:100%;border-collapse:collapse;margin-top:12px;">
                        <tr>
                            <td style="padding:8px 0;color:#374151;width:60%;"><strong>Receipt #</strong></td>
                            <td style="padding:8px 0;text-align:right;color:#111827;">{{ $viewingSantha['receipt_number'] }}</td>
                        </tr>
                        <tr>
                            <td style="padding:8px 0;color:#374151;width:60%;"><strong>Date</strong></td>
                            <td style="padding:8px 0;text-align:right;color:#111827;">{{ $viewingSantha['payment_date'] }}</td>
                        </tr>
                    </table>

                    <hr style="border:none;border-top:1px solid #e6e9ee;margin:12px 0;">

                    <div style="color:#374151;font-size:14px;line-height:1.5;margin-bottom:10px;">
                        <div><strong>Family:</strong> {{ $viewingSantha['family_name'] }}</div>
                        <div><strong>Phone:</strong> {{ $viewingSantha['family_phone'] }}</div>
                        <div><strong>Period:</strong> {{ $viewingSantha['month'] }} {{ $viewingSantha['year'] }}</div>
                    </div>

                    <hr style="border:none;border-top:1px solid #e6e9ee;margin:12px 0;">

                    <div style="display:flex;justify-content:space-between;align-items:center;margin-top:8px;">
                        <div style="font-weight:600;color:#111827;">Amount Paid</div>
                        <div style="font-size:18px;font-weight:700;color:#0f172a;">LKR {{ number_format($viewingSantha['amount'], 2) }}</div>
                    </div>
                    <div style="color:#6b7280;margin-top:8px;font-size:13px;">Method: {{ ucfirst($viewingSantha['payment_method']) }}</div>
                    @if(!empty($viewingSantha['notes']))
                        <div style="margin-top:8px;font-size:13px;color:#374151;">Notes: {{ $viewingSantha['notes'] }}</div>
                    @endif

                    <div style="text-align:left;color:#9ca3af;margin-top:16px;font-size:12px;">This receipt is generated by {{ config('app.name') }}.</div>
                </div>
            </div>
        </div>
    @endif

    <script>
        function _getSanthaPrintableHtml() {
            const content = document.getElementById('santha-receipt-content');
            if (!content) return '';

            const clone = content.cloneNode(true);
            function sanitize(node) {
                if (node.className) {
                    node.className = node.className.replace(/\bdark:[^\s]+\b/g, '').replace(/\bbg-[^\s]+\b/g, '').replace(/\btext-[^\s]+\b/g, '');
                }
                Array.from(node.children || []).forEach(child => sanitize(child));
            }
            sanitize(clone);

            const wrapperStyle = [
                'width:640px',
                'margin:0 auto',
                'padding:20px',
                'background:#ffffff',
                'color:#111827',
                "font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial",
            ].join(';');

            return `<!doctype html><html><head><meta charset="utf-8"><title>Santha Receipt</title>` +
                '<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">' +
                `<style>body{margin:0;padding:20px;background:#f3f4f6} .receipt-container{${wrapperStyle}} .text-center{text-align:center} .font-bold{font-weight:700}</style>` +
                '</head><body><div class="receipt-container">' + clone.innerHTML + '</div></body></html>';
        }

        function printSanthaReceipt() {
            const html = _getSanthaPrintableHtml();
            if (!html) return;
            const w = window.open('', '_blank');
            w.document.open();
            w.document.write(html);
            w.document.close();
            w.focus();
            setTimeout(() => { w.print(); }, 600);
        }

        function downloadSanthaReceipt() {
            const printableHtml = _getSanthaPrintableHtml();
            if (!printableHtml) return;
            const temp = document.createElement('div');
            temp.style.position = 'fixed';
            temp.style.left = '-9999px';
            temp.innerHTML = printableHtml;
            document.body.appendChild(temp);

            const render = () => {
                if (window.html2pdf) {
                    html2pdf().from(temp).set({margin:10, filename: 'santha_receipt_'+Date.now()+'.pdf', jsPDF:{unit:'pt', format:'a4', orientation:'portrait'}}).save().then(() => temp.remove());
                } else {
                    const s = document.createElement('script');
                    s.src = 'https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js';
                    s.onload = () => { html2pdf().from(temp).set({margin:10, filename: 'santha_receipt_'+Date.now()+'.pdf', jsPDF:{unit:'pt', format:'a4', orientation:'portrait'}}).save().then(() => temp.remove()); };
                    document.head.appendChild(s);
                }
            };

            setTimeout(render, 200);
        }
    </script>
</div>
