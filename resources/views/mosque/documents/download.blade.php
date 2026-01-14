<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $document->title }} - {{ $document->reference_no }}</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.5;
            color: #334155;
            background-color: #fff;
        }
        .container {
            width: 170mm;
            margin: 10mm auto;
            position: relative;
        }
        
        /* Header Table */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            border-bottom: 4px solid #064e3b;
        }
        .header-table td {
            vertical-align: middle;
            padding: 10px 0 20px 0;
        }
        .mosque-name {
            font-size: 24pt;
            font-weight: bold;
            color: #064e3b;
            text-transform: uppercase;
            margin: 0;
            text-align: center;
        }
        .contact-info {
            font-size: 8pt;
            color: #64748b;
            text-align: right;
            line-height: 1.2;
        }
        .contact-title {
            font-size: 7pt;
            font-weight: bold;
            color: #064e3b;
            opacity: 0.5;
            text-transform: uppercase;
            margin-bottom: 2px;
        }

        /* Meta Info Table */
        .meta-table {
            width: 100%;
            margin-bottom: 25px;
        }
        .meta-box {
            border-left: 4px solid #064e3b;
            padding-left: 15px;
        }
        .meta-label {
            font-size: 8pt;
            font-weight: bold;
            color: #94a3b8;
            text-transform: uppercase;
            margin-bottom: 2px;
        }
        .meta-value {
            font-size: 10pt;
            font-weight: bold;
            color: #0f172a;
        }

        /* Recipient Section */
        .recipient-section {
            margin-bottom: 25px;
            padding-left: 20px;
        }
        .recipient-label {
            font-size: 8pt;
            font-weight: bold;
            color: #cbd5e1;
            text-transform: uppercase;
            margin-bottom: 8px;
        }
        .recipient-name {
            font-size: 18pt;
            font-weight: bold;
            color: #0f172a;
            text-transform: uppercase;
            margin: 0;
        }
        .recipient-address {
            font-size: 11pt;
            color: #64748b;
            margin-top: 5px;
        }

        /* Content Area */
        .subject-line {
            font-size: 13pt;
            font-weight: bold;
            color: #0f172a;
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 10px;
            margin-bottom: 20px;
            text-transform: uppercase;
        }
        .document-content {
            font-size: 11pt;
            color: #1e293b;
            text-align: justify;
        }

        /* Signatories Table */
        .signatories-table {
            width: 100%;
            margin-top: 30px;
            border-top: 1px solid #f1f5f9;
            padding-top: 20px;
        }
        .signature-line {
            border-bottom: 1px solid #e2e8f0;
            height: 40px;
            margin-bottom: 10px;
        }
        .signatory-name {
            font-size: 11pt;
            font-weight: bold;
            color: #0f172a;
            text-transform: uppercase;
            margin: 0;
        }
        .signatory-role {
            font-size: 8pt;
            font-weight: bold;
            color: #94a3b8;
            text-transform: uppercase;
            margin-top: 4px;
        }

        /* Footer */
        .footer {
            position: absolute;
            bottom: 30px;
            left: 0;
            right: 0;
            text-align: center;
            border-top: 1px solid #f1f5f9;
            padding-top: 15px;
            font-size: 7.5pt;
            color: #cbd5e1;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Watermark (Simplified for PDF) */
        .watermark-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 100pt;
            color: #f8fafc;
            opacity: 0.1;
            z-index: -1;
            text-transform: uppercase;
            font-weight: bold;
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <div class="watermark-text">OFFICIAL</div>

    <div class="container">
        <!-- Header -->
        <table class="header-table">
            <tr>
                <td style="width: 20%;">
                    @if($document->mosque->logo)
                        <img src="{{ public_path('storage/' . $document->mosque->logo) }}" style="width: 60px; height: 60px;">
                    @endif
                </td>
                <td style="width: 60%; text-align: center;">
                    <h1 class="mosque-name">{{ $document->mosque->name }}</h1>
                    <div style="height: 2px; width: 40px; background-color: #f1f5f9; margin: 10px auto 0;"></div>
                </td>
                <td style="width: 20%; text-align: right;">
                    <div class="contact-title">Contact Office</div>
                    <div class="contact-info">
                        {{ $document->mosque->phone }}<br>
                        {{ $document->mosque->email }}<br>
                        <span style="color: #cbd5e1; font-weight: bold; font-size: 7pt;">{{ strtoupper($document->mosque->city) }}</span>
                    </div>
                </td>
            </tr>
        </table>

        <!-- Meta Info -->
        <table class="meta-table">
            <tr>
                <td style="width: 50%;">
                    <div class="meta-box">
                        <div class="meta-label">Reference No.</div>
                        <div class="meta-value">{{ $document->reference_no }}</div>
                    </div>
                </td>
                <td style="width: 50%; text-align: right;">
                    <div class="meta-label">Dated</div>
                    <div class="meta-value">{{ $document->document_date->format('d F, Y') }}</div>
                </td>
            </tr>
        </table>

        <!-- Recipient -->
        <div class="recipient-section">
            <div class="recipient-label">Recipient Information</div>
            <h2 class="recipient-name">{{ $document->recipient_name }}</h2>
            <div class="recipient-address">{{ $document->recipient_address }}</div>
        </div>

        <!-- Subject -->
        <div class="subject-line">
            Subject: {{ $document->title }}
        </div>

        <!-- Content -->
        <div class="document-content">
            {!! $content !!}
        </div>

        <!-- Signatories -->
        <table class="signatories-table">
            <tr>
                @foreach($signatories as $index => $signatory)
                    @if($index > 0 && $index % 2 == 0) </tr><tr> @endif
                    <td style="width: 50%; padding-bottom: 30px; @if($index % 2 == 0) padding-right: 40px; @else padding-left: 40px; text-align: right; @endif">
                        <div style="font-size: 8pt; font-weight: bold; color: #cbd5e1; text-transform: uppercase; margin-bottom: 15px;">Authorized</div>
                        <div class="signature-line"></div>
                        <div class="signatory-name">{{ $signatory->name }}</div>
                        <div class="signatory-role">{{ $signatory->board_role ? str_replace('_', ' ', $signatory->board_role) : 'Administrator' }}</div>
                    </td>
                @endforeach
            </tr>
        </table>

        <!-- Footer -->
        <div class="footer">
            This is an officially generated mosque document. Verify authenticity with the office of {{ $document->mosque->name }}.
        </div>
    </div>
</body>
</html>
