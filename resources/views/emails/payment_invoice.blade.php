<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>إشعار دفع جديد - {{ config('app.name') }}</title>
</head>

<body
    style="font-family: 'Tahoma', sans-serif; background:#f8fafc; padding:30px; color:#1e293b; direction: rtl; text-align: right;">

    <div
        style="max-width:700px; margin:auto; background:white; border-radius:10px; padding:40px; box-shadow:0 5px 15px rgba(0,0,0,0.05);">

        <!-- Header -->
        <div
            style="display:flex; justify-content:space-between; align-items:center; flex-direction: row-reverse; border-bottom:2px solid #e2e8f0; padding-bottom:20px; margin-bottom:25px;">
            <div style="text-align:right; font-size:13px; color:#475569;">
                <p><strong>التاريخ:</strong> {{ $payment->created_at->format('Y-m-d H:i') }}</p>
                <p><strong>رقم الفاتورة:</strong> {{ $payment->invoice_id }}</p>
                <p><strong>الحالة:</strong> {{ $payment->status->label('ar') }}</p>
            </div>
            <div>
                <h2 style="margin:0; color:#0f172a;">إشعار دفع جديد 💳</h2>
                <p style="color:#64748b; font-size:13px;">تمت عملية دفع جديدة عبر النظام</p>
            </div>
        </div>

        <!-- معلومات الدفع والمستخدم -->
        <div
            style="display:flex; justify-content:space-between; gap:20px; flex-direction: row-reverse; margin-bottom:25px;">
            <!-- بيانات الدفع -->
            <div style="width:48%; background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:15px;">
                <h3 style="font-size:14px; margin-bottom:8px; border-bottom:1px solid #e2e8f0; padding-bottom:4px;">
                    بيانات الدفع</h3>
                <p><strong>المبلغ:</strong> {{ $payment->amount }} {{ $payment->currency }}</p>
                <p><strong>الخصم:</strong> {{ $payment->discount ?? 0 }}</p>
                <p><strong>خصم العضوية:</strong> {{ $payment->membership_discount ?? 0 }}</p>
                <p><strong>الإجمالي:</strong> {{ $payment->amount }}</p>
                <p><strong>طريقة الدفع:</strong> {{ $payment->company ?? 'غير محدد' }}</p>
            </div>

            <!-- بيانات المستخدم -->
            <div style="width:48%; background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:15px;">
                <h3 style="font-size:14px; margin-bottom:8px; border-bottom:1px solid #e2e8f0; padding-bottom:4px;">
                    بيانات المستخدم</h3>
                <p><strong>الاسم:</strong> {{ $payment->user->name }}</p>
                <p><strong>البريد:</strong> {{ $payment->user->email }}</p>
                <p><strong>الهاتف:</strong> {{ $payment->user->phone }}</p>
                <p><strong>العضوية:</strong>
                    @if ($payment->user && $payment->user->membership)
                        {{ $payment->user->membership->getTranslation('name', 'ar') }}
                    @else
                        لا يوجد
                    @endif
                </p>

            </div>
        </div>

        <!-- تفاصيل العنصر -->
        <table width="100%" style="border-collapse:collapse; margin-bottom:25px; direction: rtl;">
            <thead>
                <tr style="background:#f1f5f9;">
                    <th style="padding:10px; text-align:right;">الوصف</th>
                    <th style="padding:10px; text-align:right;">السعر</th>
                    <th style="padding:10px; text-align:right;">الخصم</th>
                    <th style="padding:10px; text-align:right;">خصم العضوية</th>
                    <th style="padding:10px; text-align:right;">الإجمالي</th>
                </tr>
            </thead>
            <tbody>
                <tr style="border-bottom:1px solid #f1f5f9;">
                    <td style="padding:10px; text-align:right;">
                        @if ($payable instanceof \App\Models\Event)
                            <strong>تسجيل في الفعالية:</strong> {{ $payable->title_ar ?? $payable->title_en }}
                        @elseif ($payable instanceof \App\Models\Library)
                            <strong>شراء كتاب:</strong> {{ $payable->title_ar ?? $payable->title_en }}
                        @else
                            <strong>خدمة:</strong> {{ $payable->getTranslation('name', 'ar') ?? 'غير محدد' }}
                        @endif
                    </td>
                    <td style="padding:10px; text-align:right;">{{ $payment->original_price ?? 0 }}</td>
                    <td style="padding:10px; text-align:right;">{{ $payment->discount ?? 0 }}</td>
                    <td style="padding:10px; text-align:right;">{{ $payment->membership_discount ?? 0 }}</td>
                    <td style="padding:10px; text-align:right;">{{ $payment->amount }}</td>
                </tr>
            </tbody>
        </table>

        <div style="text-align:center; margin-top:25px;">
            <a href="{{ route('admin.members.show', ['user' => $payment->user]) }}"
                style="
                   display:inline-block;
                   background:#5f652c;
                   color:#ffffff;
                   font-weight:600;
                   padding:12px 28px;
                   border-radius:8px;
                   text-decoration:none;
                   font-size:14px;
                   box-shadow:0 4px 12px rgba(0,0,0,0.1);
                   transition:all 0.2s ease-in-out;
               "
                onmouseover="this.style.background='#1e40af'; this.style.transform='translateY(-2px)';"
                onmouseout="this.style.background='#5f652c'; this.style.transform='translateY(0)';">
                عرض بيانات المستخدم
            </a>
        </div>

    </div>
</body>

</html>
