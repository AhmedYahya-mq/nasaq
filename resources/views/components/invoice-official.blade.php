@props([
    'companyName' => 'Nasaq',
    'companyAddress' => '61 Lordou Vironos Street, Larnaca 6023, Cyprus',
    'companyVAT' => 'CY10301365E',
    'invoiceId' => 'HCY-9885878',
    'invoiceDate' => 'Nov 16, 2024',
    'nextBillingDate' => 'Nov 16, 2025',
    'invoiceAmount' => '$10.17 (USD)',
    'orderNumber' => 'hb_21397004',
    'status' => 'PAID',
    'clientName' => 'Ahmed Yahya',
    'clientEmail' => 'm733716220@gmail.com',
    'clientCountry' => 'Yemen',
    'clientPhone' => '967771508902',
    'services' => [
        [
            'description' => '.COM Domain (billed every year) fursatyeducation.com',
            'price' => '16.99 x 1 ($7.00)',
            'total' => '9.99',
            'vat' => '0.00',
            'totalIncVAT' => '9.99',
            'period' => 'Nov 16, 2024 to Nov 16, 2025',
        ],
        [
            'description' => 'Domain WHOIS Privacy Protection',
            'price' => '$0.00 x 1',
            'total' => '0.00',
            'vat' => '0.00',
            'totalIncVAT' => '0.00',
            'period' => 'Nov 16, 2024 to Nov 16, 2025',
        ],
        [
            'description' => 'ICANN fee (billed every year)',
            'price' => '$0.18 x 1',
            'total' => '0.18',
            'vat' => '0.00',
            'totalIncVAT' => '0.18',
            'period' => 'Nov 16, 2024 to Nov 16, 2025',
        ],
    ],
    'totalExclVAT' => '10.17',
    'total' => '10.17',
    'payments' => '($10.17)',
    'amountDue' => '$0.00',
    'downloadable' => true,
])

@push('scripts')
    @vite(['resources/js/pages/print.js'])
    <style>
        #invoiceCard {
            width: 1000px;
            background: #fff;
            color: #333;
            padding: 40px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-family: 'Segoe UI', Tahoma, sans-serif;
            direction: ltr;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header-left {
            display: flex;
            align-items: center;
            justify-content:  center;
            gap: 10px;
        }

        .header-left img {
            width: 50px;
            height: 50px;
        }

        .invoice-title {
            font-size: 28px;
            font-weight: bold;
            color: #333;
        }

        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .info-block {
            width: 48%;
        }

        .info-block h3 {
            font-size: 16px;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .info-block p {
            margin: 3px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px 10px;
            text-align: left;
        }

        th {
            background: #f0f0f0;
        }

        .totals {
            width: 400px;
            float: left;
            margin-top: 10px;
        }

        .totals td {
            border: none;
            padding: 4px 0;
        }

        .footer {
            border-top: 1px solid #ccc;
            margin-top: 40px;
            text-align: center;
            font-size: 13px;
            color: #555;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: white;
            }
        }
    </style>
@endpush

<div x-data="printInit" class="flex flex-col items-center w-full space-y-6">

    <div class="scrollbar flex flex-col items-center w-full m-0 p-0">
        <div id="invoiceCard" x-ref="card">

            <!-- Header -->
            <div class="header">
                <div class="header-left">
                    <img src="{{ asset('favicon.ico') }}" alt="Logo">
                    <div class="invoice-title">{{ $companyName }}</div>
                </div>
            </div>

            <!-- Info Section -->
            <div class="info-section">
                <div class="info-block">
                    <h3>Payment Info</h3>
                    <p><strong>Invoice #:</strong> {{ $payment->invoice_id }}</p>
                    <p><strong>Invoice Issued:</strong> {{ $payment->created_at }}</p>
                    <p><strong>Invoice Amount:</strong> {{ $payment->amount }}</p>
                    <p><strong>Order Nr.:</strong> {{ $payment->id }}</p>
                    <p><strong>Status:</strong> {{ $payment->status->label('en') }}</p>
                </div>

                <div class="info-block">
                    <h3>Billed To</h3>
                    <p><strong>Name:</strong> {{ $payment->user->name }}</p>
                    <p><strong>Email:</strong> {{ $payment->user->email }}</p>
                    <p><strong>Phone:</strong> {{ $payment->user->phone }}</p>
                </div>
            </div>

            <!-- Table -->
            <table>
                <thead>
                    <tr>
                        <th>DESCRIPTION</th>
                        <th>PRICE</th>
                        <th>TOTAL</th>
                        <th>EXCL. VAT</th>
                        <th>VAT AMOUNT (USD)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($services as $item)
                        <tr>
                            <td>{{ $item['description'] }}<br><small>{{ $item['period'] ?? '' }}</small></td>
                            <td>{{ $item['price'] }}</td>
                            <td>{{ $item['total'] }}</td>
                            <td>{{ $item['vat'] }}</td>
                            <td>{{ $item['totalIncVAT'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Totals -->
            <table class="totals">
                <tr><td>Total excl. VAT</td><td>{{ $totalExclVAT }}</td></tr>
                <tr><td>Total</td><td>{{ $total }}</td></tr>
                <tr><td>Payments</td><td>{{ $payments }}</td></tr>
                <tr><td>Amount Due (USD)</td><td>{{ $amountDue }}</td></tr>
            </table>

            <!-- Footer -->
            <div class="footer">
                {{ $companyName }} © {{ date('Y') }} | VAT Reg #: {{ $companyVAT }}<br>
                {{ $companyAddress }}
            </div>
        </div>
    </div>

    <!-- Buttons -->
    @if ($downloadable)
        <div class="flex flex-col md:flex-row items-center gap-4 no-print">
            <button @click="downloadTransparent"
                class="btn flex justify-center items-center gap-2 bg-primary/40 hover:bg-primary/30 py-2 px-4 rounded mt-5">
                🖼️ Download as Image
            </button>
            <button @click="downloadPDF"
                class="btn flex justify-center items-center gap-2 bg-primary/40 hover:bg-primary/30 py-2 px-4 rounded mt-5">
                📄 Download PDF
            </button>
        </div>
    @endif
</div>
