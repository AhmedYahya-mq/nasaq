<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فاتورة مبيعات</title>
    <style>
        @font-face {
            font-family: 'Tajawal';
            font-style: normal;
            font-weight: 400;
            src: url("{{ resource_path('fonts/Tajawal-Regular.ttf') }}") format('truetype');
        }

        body,
        * {
            font-family: 'Tajawal', sans-serif !important;
            direction: rtl;
        }

        /* أنماط عامة */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f5f7fa;
            color: #333;
            padding: 20px;
            line-height: 1.6;
        }

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        /* رأس الفاتورة */
        .invoice-header {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .invoice-title {
            font-size: 28px;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .invoice-subtitle {
            font-size: 16px;
            opacity: 0.9;
        }

        /* معلومات الشركة والعملاء */
        .invoice-info {
            display: flex;
            justify-content: space-between;
            padding: 25px;
            border-bottom: 1px solid #eee;
        }

        .company-info,
        .client-info {
            flex: 1;
        }

        .info-title {
            font-weight: 600;
            margin-bottom: 10px;
            color: #6a11cb;
            font-size: 18px;
        }

        .info-detail {
            margin-bottom: 5px;
        }

        /* تفاصيل الفاتورة */
        .invoice-details {
            padding: 25px;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .details-table th {
            background-color: #f8f9fa;
            padding: 12px 15px;
            text-align: right;
            font-weight: 600;
            color: #555;
            border-bottom: 2px solid #e9ecef;
        }

        .details-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #e9ecef;
        }

        .details-table tr:last-child td {
            border-bottom: none;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        /* قسم المجموع */
        .invoice-total {
            background-color: #f8f9fa;
            padding: 20px 25px;
            text-align: left;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .total-final {
            font-size: 20px;
            font-weight: 700;
            color: #6a11cb;
            border-top: 2px solid #e9ecef;
            padding-top: 10px;
            margin-top: 10px;
        }

        /* تذييل الفاتورة */
        .invoice-footer {
            padding: 20px 25px;
            text-align: center;
            background-color: #f1f3f4;
            color: #666;
            font-size: 14px;
        }

        .thank-you {
            font-size: 16px;
            margin-bottom: 10px;
            color: #6a11cb;
            font-weight: 600;
        }

        /* تأثيرات تفاعلية بسيطة */
        .details-table tr:hover {
            background-color: #f8f9fa;
        }

        /* طباعة الفاتورة */
        @media print {
            body {
                background: white;
                padding: 0;
            }

            .invoice-container {
                box-shadow: none;
                border-radius: 0;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <!-- رأس الفاتورة -->
        <div class="invoice-header">
            <h1 class="invoice-title">فاتورة مبيعات</h1>
            <p class="invoice-subtitle">شكراً لثقتكم ودعمكم المستمر</p>
        </div>

        <!-- معلومات الشركة والعملاء -->
        <div class="invoice-info">
            <div class="company-info">
                <h3 class="info-title">معلومات البائع</h3>
                <p class="info-detail"><strong>شركة التقنية المتطورة</strong></p>
                <p class="info-detail">الرياض، المملكة العربية السعودية</p>
                <p class="info-detail">هاتف: 0112345678</p>
                <p class="info-detail">البريد الإلكتروني: info@tech.com</p>
            </div>

            <div class="client-info">
                <h3 class="info-title">معلومات العميل</h3>
                <p class="info-detail"><strong>أحمد محمد</strong></p>
                <p class="info-detail">جدة، المملكة العربية السعودية</p>
                <p class="info-detail">هاتف: 0501234567</p>
                <p class="info-detail">البريد الإلكتروني: ahmed@example.com</p>
            </div>
        </div>

        <!-- تفاصيل الفاتورة -->
        <div class="invoice-details">
            <h3 class="info-title">تفاصيل الفاتورة</h3>
            <table class="details-table">
                <thead>
                    <tr>
                        <th class="text-right">الوصف</th>
                        <th class="text-center">الكمية</th>
                        <th class="text-center">سعر الوحدة</th>
                        <th class="text-right">المجموع</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>لابتوب ديل - طراز XPS 13</td>
                        <td class="text-center">1</td>
                        <td class="text-center">4,200 ر.س</td>
                        <td class="text-right">4,200 ر.س</td>
                    </tr>
                    <tr>
                        <td>ماوس لاسلكي</td>
                        <td class="text-center">2</td>
                        <td class="text-center">150 ر.س</td>
                        <td class="text-right">300 ر.س</td>
                    </tr>
                    <tr>
                        <td>حقيبة لابتوب</td>
                        <td class="text-center">1</td>
                        <td class="text-center">250 ر.س</td>
                        <td class="text-right">250 ر.س</td>
                    </tr>
                    <tr>
                        <td>ضمان إضافي لمدة سنتين</td>
                        <td class="text-center">1</td>
                        <td class="text-center">500 ر.س</td>
                        <td class="text-right">500 ر.س</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- قسم المجموع -->
        <div class="invoice-total">
            <div class="total-row">
                <span>المجموع الفرعي:</span>
                <span>5,250 ر.س</span>
            </div>
            <div class="total-row">
                <span>ضريبة القيمة المضافة (15%):</span>
                <span>787.5 ر.س</span>
            </div>
            <div class="total-row total-final">
                <span>المجموع الكلي:</span>
                <span>6,037.5 ر.س</span>
            </div>
        </div>

        <!-- تذييل الفاتورة -->
        <div class="invoice-footer">
            <p class="thank-you">شكراً لتعاملكم معنا</p>
            <p>للاستفسارات، يرجى الاتصال على: 0112345678 أو إرسال بريد إلكتروني إلى info@tech.com</p>
            <p>سياسة الإرجاع: يمكن إرجاع المنتجات خلال 14 يومًا من تاريخ الشراء بشروط معينة</p>
        </div>
    </div>
</body>

</html>
