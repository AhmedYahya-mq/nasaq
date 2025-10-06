{{-- resources/views/components/invoice-hostinger-style.blade.php --}}
@props([
    'companyName' => 'Hostinger International Ltd.',
    'companyAddress' => '61 Lordou Vironos Street, Larnaca 6023, Cyprus',
    'companyVAT' => 'CY10301365E',
    'invoiceId' => 'HCY-9885878',
    'invoiceDate' => 'Nov 16, 2024',
    'nextBillingDate' => 'Nov 16, 2025',
    'invoiceAmount' => '$10.17 (USD)',
    'orderNumber' => 'hb_21397004',
    'status' => 'PAID',
    'clientName' => 'ahmed Yahya',
    'clientEmail' => 'm733716220@gmail.com',
    'clientCountry' => 'Yemen',
    'clientPhone' => '967771508902',
    'services' => [
        ['description' => '.COM Domain (billed every year) fursatyeducation.com', 'price' => '16.99 x 1 ($7.00)', 'total' => '9.99', 'vat' => '0.00', 'totalIncVAT' => '9.99', 'period' => 'Nov 16, 2024 to Nov 16, 2025'],
        ['description' => 'Domain WHOIS Privacy Protection', 'price' => '$0.00 x 1', 'total' => '0.00', 'vat' => '0.00', 'totalIncVAT' => '0.00', 'period' => 'Nov 16, 2024 to Nov 16, 2025'],
        ['description' => 'ICANN fee (billed every year)', 'price' => '$0.18 x 1', 'total' => '0.18', 'vat' => '0.00', 'totalIncVAT' => '0.18', 'period' => 'Nov 16, 2024 to Nov 16, 2025'],
    ],
    'totalExclVAT' => '10.17',
    'total' => '10.17',
    'payments' => '($10.17)',
    'amountDue' => '$0.00',
    'qrCode' => 'https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=HCY-9885878',
])

@push('scripts')
@vite(['resources/js/pages/print.js'])
<style>
#invoiceCard {
    width: 1000px; /* حجم ثابت وعريض */
    background: #fff;
    color: #333;
    padding: 40px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-family: 'Segoe UI', Tahoma, sans-serif;
    overflow: auto;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 30px;
}

.header .invoice-title { font-size: 28px; font-weight: bold; }

.header img { width: 80px; height: 80px; }

.info-section {
    display: flex;
    justify-content: space-between;
    margin-bottom: 30px;
}

.info-block { width: 48%; }

.info-block h3 { font-size: 16px; margin-bottom: 10px; font-weight: bold; }

.info-block p { margin: 3px 0; }

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

th { background: #f0f0f0; }

.totals {
    width: 400px;
    float: left;
    margin-top: 10px;
}

.totals td { border: none; padding: 4px 0; }

.footer {
    border-top: 1px solid #ccc;
    margin-top: 30px;
    text-align: center;
    font-size: 13px;
    color: #555;
}

.print-btn, .pdf-btn {
    background: none;
    border: 1px solid #ccc;
    padding: 8px 14px;
    border-radius: 6px;
    cursor: pointer;
    margin: 20px;
}
.pdf-btn { display: block; margin: 20px auto 0; }

@media print {
    .print-btn, .pdf-btn { display: none !important; }
    body { background: white; }
}
</style>
@endpush

<div x-data="printInit" class="flex flex-col items-center w-full">
    <!-- زر الطباعة -->
    <button @click="printCard" class="print-btn">🖨️ طباعة الفاتورة</button>

    <!-- الفاتورة -->
    <div id="invoiceCard" x-ref="card">
        <div class="header">
            <div class="invoice-title">INVOICE</div>
            <img src="{{ asset('favicon.ico') }}" alt="Logo">
        </div>

        <div class="info-section">
            <!-- الدفع -->
            <div class="info-block">
                <h3>Payment Info</h3>
                <p><strong>Invoice #:</strong> {{ $invoiceId }}</p>
                <p><strong>Invoice Issued #:</strong> {{ $invoiceDate }}</p>
                <p><strong>Next Billing Date #:</strong> {{ $nextBillingDate }}</p>
                <p><strong>Invoice Amount #:</strong> {{ $invoiceAmount }}</p>
                <p><strong>Order Nr. #:</strong> {{ $orderNumber }}</p>
                <p><strong>Status:</strong> {{ $status }}</p>
            </div>

            <!-- العميل -->
            <div class="info-block">
                <h3>Billed To</h3>
                <p><strong>Name:</strong> {{ $clientName }}</p>
                <p><strong>Email:</strong> {{ $clientEmail }}</p>
                <p><strong>Country:</strong> {{ $clientCountry }}</p>
                <p><strong>Phone:</strong> {{ $clientPhone }}</p>
            </div>
        </div>

        <!-- الخدمات -->
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

        <!-- ملخص -->
        <table class="totals">
            <tr><td>Total excl. VAT</td><td>{{ $totalExclVAT }}</td></tr>
            <tr><td>Total</td><td>{{ $total }}</td></tr>
            <tr><td>Payments</td><td>{{ $payments }}</td></tr>
            <tr><td>Amount Due (USD)</td><td>{{ $amountDue }}</td></tr>
        </table>

        <div class="footer">
            <img src="{{ $qrCode }}" alt="QR" style="width:80px;margin-top:10px;"><br>
            {{ $companyName }} © {{ date('Y') }} | VAT Reg #: {{ $companyVAT }}<br>
            {{ $companyAddress }}
        </div>
    </div>

    <!-- زر تحميل PDF -->
    <button @click="downloadPDF" class="pdf-btn">📄 تحميل الفاتورة PDF</button>
</div>
