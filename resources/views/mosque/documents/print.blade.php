<!DOCTYPE html>
<html lang="{{ $document->language }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $document->title }} - {{ $document->reference_no }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&family=Amiri:wght@400;700&family=Noto+Sans+Sinhala:wght@400;700&family=Noto+Sans+Tamil:wght@400;700&display=swap" rel="stylesheet">
    <style>
        @page {
            size: A4;
            margin: 0;
        }
        body {
            font-family: 'Inter', 'Amiri', 'Noto Sans Sinhala', 'Noto Sans Tamil', sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 20mm 0;
            -webkit-print-color-adjust: exact;
        }
        @media print {
            body { background-color: white; padding: 0; }
        }
        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 20mm;
            margin: 0 auto;
            position: relative;
            box-sizing: border-box;
            background-color: white;
            overflow: hidden;
        }

        /* Islamic Vibe Elements */
        .islamic-pattern-teal {
            background-color: #064e3b; /* Deep Teal */
            background-image: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M20 0l4 12 12 4-12 4-4 12-4-12-12-4 12-4z' fill='%23059669' fill-opacity='0.2'/%3E%3C/svg%3E");
        }
        
        .watermark {
            position: absolute;
            top: 55%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-30deg);
            font-size: 150px;
            color: rgba(6, 78, 59, 0.03);
            pointer-events: none;
            z-index: 0;
            white-space: nowrap;
            user-select: none;
        }

        .watermark-pattern {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 500px;
            height: 500px;
            opacity: 0.04;
            z-index: 0;
            pointer-events: none;
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M50 0l15 35 35 15-35 15-15 35-15-35-35-15 35-15z' fill='%23064e3b'/%3E%3C/svg%3E");
            background-size: 100px 100px;
        }

        @media print {
            .no-print { display: none !important; }
            .page {
                margin: 0;
                box-shadow: none;
                padding: 15mm;
            }
        }
        .sidebar-template {
            display: flex;
            min-height: 250mm;
        }
        .sidebar {
            width: 60mm;
            border-right: 1.5pt solid #333;
            padding-right: 5mm;
            flex-shrink: 0;
        }
        .main-body {
            padding-left: 10mm;
            flex-grow: 1;
        }
        .signature-box {
            min-height: 40mm;
            margin-top: 20mm;
        }
        .stamp-circle {
            width: 30mm;
            height: 30mm;
            border: 1pt dashed #ccc;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
            color: #999;
            text-transform: uppercase;
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Letterhead -->
    <div class="page bg-white shadow-2xl relative">
        <!-- Watermark Pattern -->
        <div class="watermark-pattern"></div>
        @php
            $headerHtml = '
            <div class="relative -mx-[20mm] -mt-[20mm] mb-8 border-b-4 border-[#064e3b]">
                <!-- Premium Compact Header -->
                <div class="bg-white p-6 grid grid-cols-5 items-center">
                    <!-- Left: Logo -->
                    <div class="col-span-1">
                        '.($document->mosque->logo ? '
                        <div class="bg-slate-50 p-1.5 rounded-xl inline-block border border-slate-50">
                            <img src="'.asset('storage/' . $document->mosque->logo).'" class="h-14 w-14 object-contain">
                        </div>
                        ' : '').'
                    </div>

                    <!-- Center: Masjid Name (Premium Branding) -->
                    <div class="col-span-3 text-center px-4">
                        <h1 class="text-3xl md:text-4xl font-black uppercase tracking-[0.05em] leading-tight text-[#064e3b]">
                            '.$document->mosque->name.'
                        </h1>
                        <div class="h-0.5 w-12 bg-slate-100 mx-auto mt-2 rounded-full"></div>
                    </div>

                    <!-- Right: Contact Office -->
                    <div class="col-span-1 text-right">
                        <p class="text-[8px] font-black uppercase tracking-widest text-[#064e3b] opacity-30 mb-1">Contact Office</p>
                        <div class="space-y-0 text-[10px] font-bold text-slate-500 leading-tight">
                            <p>'.$document->mosque->phone.'</p>
                            <p>'.$document->mosque->email.'</p>
                            <p class="text-[9px] uppercase font-black mt-1 text-slate-300">'.$document->mosque->city.'</p>
                        </div>
                    </div>
                </div>
            </div>';
        @endphp

        @if($document->template_type === 'classic')
            <!-- SIMPLE CLASSIC -->
            <div class="relative flex flex-col min-h-[260mm]">
                {!! $headerHtml !!}

                <!-- Meta Info -->
                <div class="flex justify-between items-end mb-12 px-2">
                    <div class="border-l-4 border-[#064e3b] pl-4">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Reference No.</p>
                        <p class="text-sm font-black text-slate-900">{{ $document->reference_no }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Dated</p>
                        <p class="text-sm font-black text-slate-900">{{ $document->document_date->format('d F, Y') }}</p>
                    </div>
                </div>

                <!-- Recipient Info -->
                <div class="mb-12 px-2 pl-6">
                    <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest mb-2">Recipient Information</p>
                    <p class="text-2xl font-black text-slate-900 uppercase tracking-tight">{{ $document->recipient_name }}</p>
                    <p class="text-base text-slate-500 font-bold whitespace-pre-line leading-relaxed mt-1">{{ $document->recipient_address }}</p>
                </div>

                <!-- Document Body -->
                <div class="flex-grow px-2">
                    <h2 class="text-xl font-black text-slate-900 mb-8 pb-4 border-b border-slate-100 uppercase tracking-tight">
                        Subject: {{ $document->title }}
                    </h2>
                    
                    <div class="text-base leading-relaxed text-slate-800 space-y-6 font-medium">
                        {!! $content !!}
                    </div>
                </div>

                <!-- Signatories -->
                <div class="mt-20 flex flex-wrap @if(count($signatories) > 1) justify-between @else justify-end @endif gap-12 border-t pt-10 border-slate-100 px-2">
                    @foreach($signatories as $signatory)
                        <div class="min-w-[50mm] text-center">
                            <div class="h-10 border-b border-slate-200 mb-3"></div>
                            <p class="text-base font-black text-slate-900 uppercase leading-none">{{ $signatory->name }}</p>
                            <p class="text-[10px] font-bold text-slate-400 mt-2 uppercase tracking-widest">{{ $signatory->board_role ? str_replace('_', ' ', $signatory->board_role) : 'Administrator' }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

        @elseif($document->template_type === 'modern')
            <!-- SIMPLE MODERN -->
            <div class="relative flex flex-col min-h-[260mm]">
                {!! $headerHtml !!}

                <div class="grid grid-cols-3 gap-12 mb-16 px-6">
                    <div class="col-span-2">
                        <p class="text-[9px] font-black text-slate-300 uppercase mb-3">To Recipient</p>
                        <p class="text-2xl font-black text-slate-900 uppercase tracking-tight">{{ $document->recipient_name }}</p>
                        <p class="text-sm text-slate-500 font-bold whitespace-pre-line mt-2 leading-relaxed">{{ $document->recipient_address }}</p>
                    </div>
                    <div class="text-right flex flex-col justify-end">
                        <div class="space-y-4">
                            <div>
                                <p class="text-[9px] font-black text-slate-300 uppercase mb-0.5">Date</p>
                                <p class="text-base font-black text-slate-900">{{ $document->document_date->format('F d, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-slate-300 uppercase mb-0.5">Ref No.</p>
                                <p class="text-base font-black text-slate-900">{{ $document->reference_no }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Document Body -->
                <div class="flex-grow px-6">
                    <h2 class="text-2xl font-black text-slate-900 mb-10 pb-2 border-b-2 border-slate-900 inline-block uppercase tracking-tight">
                        {{ $document->title }}
                    </h2>
                    
                    <div class="text-base leading-relaxed text-slate-800 space-y-6 font-medium">
                        {!! $content !!}
                    </div>
                </div>

                <!-- Signatories -->
                <div class="mt-20 flex gap-12 justify-start px-6">
                    @foreach($signatories as $signatory)
                        <div class="min-w-[50mm]">
                            <p class="text-[9px] font-black text-slate-300 uppercase mb-8">Authorized</p>
                            <div class="border-t-2 border-slate-900 pt-3">
                                <p class="text-lg font-black text-slate-900 uppercase leading-none">{{ $signatory->name }}</p>
                                <p class="text-[10px] font-bold text-slate-400 mt-2 uppercase tracking-widest">{{ $signatory->board_role ? str_replace('_', ' ', $signatory->board_role) : 'Administrator' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        @else
            <!-- SIMPLE SIDEBAR -->
            <div class="relative flex flex-col min-h-[260mm]">
                {!! $headerHtml !!}
                
                <div class="flex -mx-[20mm] flex-grow">
                    <!-- Sidebar (Left) -->
                    <div class="w-[65mm] border-r border-slate-100 flex flex-col px-10 pt-4 bg-slate-50/20">
                        <div class="space-y-12">
                            <div>
                                <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest mb-6">Administrative</p>
                                <div class="space-y-10">
                                    @foreach($signatories as $signatory)
                                        <div>
                                            <p class="text-xs font-black text-slate-900 uppercase leading-none mb-1">{{ $signatory->name }}</p>
                                            <p class="text-[9px] font-bold text-[#064e3b] uppercase tracking-tight">{{ $signatory->board_role ? str_replace('_', ' ', $signatory->board_role) : 'Administrator' }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content (Right) -->
                    <div class="flex-grow bg-white p-[20mm] flex flex-col">
                        <div class="flex justify-between items-start mb-12 border-b border-slate-100 pb-6">
                            <div class="text-[10px] font-black">
                               <p class="text-slate-300 uppercase mb-1">Ref No.</p>
                               <p class="text-slate-900">{{ $document->reference_no }}</p>
                            </div>
                            <div class="text-right text-[10px] font-black">
                               <p class="text-slate-300 uppercase mb-1">Dated</p>
                               <p class="text-slate-900">{{ $document->document_date->format('d M, Y') }}</p>
                            </div>
                        </div>

                        <div class="mb-12">
                            <p class="text-[9px] font-black text-slate-300 uppercase mb-3">To Recipient:</p>
                            <p class="text-2xl font-black text-slate-900 uppercase tracking-tighter">{{ $document->recipient_name }}</p>
                            <p class="text-sm text-slate-500 font-bold whitespace-pre-line leading-relaxed mt-2">{{ $document->recipient_address }}</p>
                        </div>

                        <div class="flex-grow">
                            <h2 class="text-xl font-black text-slate-900 mb-8 pb-3 border-b border-slate-100 uppercase">
                                Subject: {{ $document->title }}
                            </h2>
                            <div class="text-base leading-relaxed text-slate-800 space-y-6 font-medium">
                                {!! $content !!}
                            </div>
                        </div>

                        <div class="mt-20 pt-8 border-t border-slate-100 text-right">
                            <p class="text-[9px] font-black text-slate-200 uppercase tracking-widest">Official Record Document</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Footer always at bottom of A4 -->
        <div class="absolute bottom-8 left-0 right-0 text-center px-16 border-t border-slate-100 pt-4">
            <p class="text-[8px] font-bold text-slate-300 uppercase tracking-[0.3em]">This is an officially generated mosque document. Verify authenticity with the office of {{ $document->mosque->name }}.</p>
        </div>
    </div>

    <script>
        window.onload = function() {
            @if(isset($autoprint) && $autoprint)
                window.print();
            @endif
        }
    </script>
</body>
</html>
