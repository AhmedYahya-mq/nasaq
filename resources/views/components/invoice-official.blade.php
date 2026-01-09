@push('scripts')
    <style>
        #invoiceCard {
            width: 1000px;
            background: #ffffff;
            color: #1e293b;
            padding: 50px 60px;
            border-radius: 14px;
            font-family: 'Inter', 'Segoe UI', Tahoma, sans-serif;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            direction: ltr;
            border: 1px solid #e2e8f0;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 25px;
            margin-bottom: 35px;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-left img {
            width: 55px;
            height: 55px;
            border-radius: 10px;
        }

        .invoice-title {
            font-size: 28px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.5px;
        }

        /* Info Section */
        .info-section {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 35px;
        }

        .info-block {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 20px;
            width: 48%;
        }

        .info-block h3 {
            font-size: 15px;
            margin-bottom: 10px;
            font-weight: 700;
            color: #0f172a;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 5px;
        }

        .info-block p {
            margin: 5px 0;
            font-size: 14px;
            color: #334155;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            margin-bottom: 30px;
            border-radius: 10px;
            overflow: hidden;
        }

        thead th {
            background: #f1f5f9;
            color: #0f172a;
            font-weight: 700;
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        tbody td {
            padding: 12px 10px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: top;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        tbody tr:hover {
            background: #f8fafc;
        }

        /* Totals */
        .totals {
            width: 320px;
            float: right;
            font-size: 15px;
        }

        .totals td {
            padding: 6px 0;
            border: none;
        }

        .totals tr td:first-child {
            color: #475569;
        }

        .totals tr:last-child td {
            font-weight: 800;
            color: #0f172a;
            border-top: 2px solid #e2e8f0;
            padding-top: 10px;
        }

        /* Footer */
        .footer {
            border-top: 1px solid #e2e8f0;
            margin-top: 60px;
            text-align: center;
            font-size: 13px;
            color: #64748b;
            padding-top: 15px;
        }

        /* Buttons */
        .no-print button {
            transition: all 0.2s ease-in-out;
            border-radius: 10px;
            font-weight: 600;
            color: #fff;
            cursor: pointer;
        }

        .no-print button:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        @media print {
            body * {
                visibility: hidden;
            }

            #invoiceCard,
            #invoiceCard * {
                visibility: visible;
            }

            #invoiceCard {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                box-shadow: none;
                border: none;
                padding: 0;
                margin: 0;
            }

            /* إخفاء أزرار الطباعة نفسها */
            .no-print {
                display: none !important;
            }
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const btn = document.querySelector('[data-invoice-print]');
            if (btn) {
                btn.addEventListener('click', () => {
                    // حفظ المحتوى الأصلي
                    const originalContent = document.body.innerHTML;

                    // استخراج محتوى الفاتورة فقط
                    const invoiceContent = document.getElementById('invoiceCard').outerHTML;

                    // استبدال محتوى body بمحتوى الفاتورة فقط
                    document.body.innerHTML = invoiceContent;

                    // الطباعة
                    window.print();

                    // استعادة المحتوى الأصلي
                    document.body.innerHTML = originalContent;
                });
            }
        });
    </script>
@endpush

@php
    $couponDiscount = (float) ($payment->coupon_discount ?? ($payment->coupon_amount ?? 0));
    $couponCode = $payment->coupon_code ?? ($payment->coupon->code ?? null);
@endphp

@php
    // طريقة 1: استخدام الصورة مع التحقق
    $logoPath = public_path('images/logo.png');
    $logoUrl = file_exists($logoPath) ? asset('images/logo.png') : '';

    // طريقة 2: استخدام SVG كبديل (الأفضل للطباعة)
    $logoSvg = '<svg xmlns="http://www.w3.org/2000/svg" width="55" height="55" viewBox="0 0 24 24" fill="#3b82f6">
        <rect width="24" height="24" rx="5" fill="#3b82f6" opacity="0.1"/>
        <path fill="#3b82f6" d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
    </svg>';
@endphp

<div class="flex flex-col items-center w-full space-y-6 py-5 box-print">

    <div class="scrollbar flex flex-col items-center w-full m-0 p-0">
        <div id="invoiceCard">

            <!-- Header -->
            <div class="header">
                <div class="header-left">
                    @if ($logoUrl)
                        <img src="{{ $logoUrl }}" alt="Logo" style="width: 55px; height: 55px;">
                    @else
                        <!-- استخدام SVG مباشرة -->
                        {!! $logoSvg !!}
                    @endif
                    <div>
                        <div class="invoice-title">{{ config('app.name') }}</div>
                        <div style="font-size: 13px; color:#64748b;">
                            Invoice Receipt
                        </div>
                    </div>
                </div>
                <div style="text-align: right; font-size: 14px; color:#475569;">
                    <p><strong>Date:</strong> {{ $payment->created_at->format('M d, Y') }}</p>
                    <p><strong>Status:</strong> {{ $payment->status->label('en') }}</p>
                    <p><strong>Invoice #:</strong> {{ $payment->invoice_id }}</p>
                </div>
            </div>

            <!-- Info Section -->
            <div class="info-section">
                <div class="info-block">
                    <h3>Payment Info</h3>
                    <p><strong>Invoice ID:</strong> {{ $payment->invoice_id }}</p>
                    <p><strong>Amount:</strong> {{ $payment->amount }}</p>
                    <p><strong>Status:</strong> {{ $payment->status->label('en') }}</p>
                    <p><strong>Currency:</strong> {{ $payment->currency }}</p>
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
                        <th>Description</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>Membership Discount</th>
                        <th>Coupon Discount</th>
                        <th>Total</th>
                        <th>Currency</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            @if ($payable instanceof \App\Models\Event)
                                <strong>Register in:</strong>
                                {{ $payment->payable->title_en ?? $payment->payable->title_ar }}
                            @elseif ($payable instanceof \App\Models\Library)
                                <strong>Purchase Book:</strong>
                                {{ $payment->payable->title_en ?? $payment->payable->title_ar }}
                            @else
                                <strong>Service:</strong>
                                {{ $payment->payable->getTranslation('name', 'en') ?? 'No title' }}
                            @endif
                        </td>
                        <td>{{ $payment->original_price ?? 0 }}</td>
                        <td>{{ $payment->discount ?? 0 }}</td>
                        <td>{{ $payment->membership_discount ?? 0 }}</td>
                        <td>
                            {{ $couponDiscount ?? 0 }}
                            @if ($couponCode)
                                <div style="font-size: 12px; color: #64748b;">Code: {{ $couponCode }}</div>
                            @endif
                        </td>
                        <td>{{ $payment->amount }}</td>
                        <td>{{ $payment->currency }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- Totals -->
            <table class="totals">
                <tr>
                    <td>Price</td>
                    <td>{{ $payment->original_price ?? 0 }}</td>
                </tr>
                <tr>
                    <td>Discount</td>
                    <td>{{ $payment->discount ?? 0 }}</td>
                </tr>
                <tr>
                    <td>Membership Discount</td>
                    <td>{{ $payment->membership_discount ?? 0 }}</td>
                </tr>
                <tr>
                    <td>Coupon Discount</td>
                    <td>{{ $couponDiscount ?? 0 }}</td>
                </tr>
                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong>{{ $payment->amount }}</strong></td>
                </tr>
            </table>

            <!-- Footer -->
            <div class="footer">
                Thank you for your payment.<br>
                For any billing inquiries,
                <a href="{{ route('client.about') }}#contact" style="color: #3b82f6; text-decoration: none;">
                    contact us
                </a>.
            </div>
        </div>
    </div>

    <!-- Buttons -->
    <div class="flex flex-col md:flex-row items-center gap-4 no-print">
        <button data-invoice-print class=" !bg-primary flex justify-center items-center gap-2 py-2 px-4 rounded mt-5">
            print
        </button>
    </div>
</div>
