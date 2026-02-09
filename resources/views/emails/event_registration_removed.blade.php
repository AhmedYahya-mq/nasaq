<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>تنبيه بخصوص تسجيل فعالية - {{ config('app.name') }}</title>
</head>

<body
    style="font-family: 'Tahoma', sans-serif; background:#f8fafc; padding:30px; color:#1e293b; direction: rtl; text-align: right; font-size:15px; line-height:1.8;">

    <div
        style="max-width:700px; margin:auto; background:white; border-radius:10px; padding:40px; box-shadow:0 5px 15px rgba(0,0,0,0.05);">

        <!-- Header -->
        <table width="100%" cellspacing="0" cellpadding="0"
            style="border-bottom:2px solid #e2e8f0; padding-bottom:20px; margin-bottom:25px;">
            <tr>
                <td style="text-align:right; vertical-align:top;">
                    <h2 style="margin:0; color:#0f172a; font-size:22px; line-height:1.4;">تنبيه مهم</h2>
                    <p style="margin:6px 0 0; color:#64748b; font-size:14px;">بخصوص تسجيلك في إحدى الفعاليات</p>
                </td>
                <td style="text-align:left; vertical-align:top; font-size:13px; color:#475569;">
                    <p style="margin:0 0 6px;"><strong>التاريخ:</strong> {{ now()->format('Y-m-d H:i') }}</p>
                    <p style="margin:0;"><strong>المرسل:</strong> {{ config('app.name') }}</p>
                </td>
            </tr>

            <tr>
                <td colspan="2" style="padding-top:14px; text-align:center;">
                    <div style="padding:0px 16px;">
                        <p style="margin:0; font-size:16px; color:#0f172a;">
                            <strong style="display: block">{{ $eventTitle }}</strong>
                        </p>
                    </div>
                </td>
            </tr>
        </table>

        <!-- Intro -->
        <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:18px; margin-bottom:18px;">
            <p style="margin:0 0 10px; font-size:15px;">
                السلام عليكم ورحمة الله وبركاته،
            </p>
            <p style="margin:0; color:#334155; font-size:15px;">
                نفيدكم بأنه تم إلغاء تسجيلكم في فعالية: <strong>{{ $eventTitle }}</strong> لعدم توفر تأكيد دفعٍ ناجح
                مرتبط بالتسجيل في النظام.
                <br>
                في حال كنتم قد أتممتم الدفع بالفعل، نرجو تجاهل هذه الرسالة والتواصل معنا لإجراء التحقق.
            </p>
        </div>

        <!-- Details -->
        <table width="100%" cellspacing="0" cellpadding="0" style="margin-bottom:18px;">
            <tr>
                <td style="width:50%; vertical-align:top; padding-left:10px;">
                    <div style="background:#ffffff; border:1px solid #e2e8f0; border-radius:8px; padding:16px;">
                        <h3
                            style="font-size:16px; margin:0 0 10px; border-bottom:1px solid #e2e8f0; padding-bottom:6px; color:#0f172a;">
                            بيانات الفعالية</h3>
                        <p style="margin:0 0 6px; font-size:14px; color:#475569;"><strong>رقم الفعالية:</strong>
                            #{{ $event->id }}</p>
                        <p style="margin:0 0 8px; font-size:15px;"><strong>التاريخ:</strong>
                            {{ optional($event->start_at)->setTimezone('Asia/Riyadh')->translatedFormat('d F Y h:i A') }}
                        </p>
                    </div>
                </td>

                <td style="width:50%; vertical-align:top; padding-right:10px;">
                    <div style="background:#ffffff; border:1px solid #e2e8f0; border-radius:8px; padding:16px;">
                        <h3
                            style="font-size:16px; margin:0 0 10px; border-bottom:1px solid #e2e8f0; padding-bottom:6px; color:#0f172a;">
                            بيانات الحساب</h3>
                        <p style="margin:0 0 8px; font-size:15px;"><strong>الاسم:</strong> {{ $user->name }}</p>
                        <p style="margin:0 0 8px; font-size:15px;"><strong>البريد:</strong> {{ $user->email }}</p>
                        <p style="margin:0; font-size:15px;"><strong>رقم المستخدم:</strong> #{{ $user->id }}</p>
                    </div>
                </td>
            </tr>
        </table>

        <!-- Next steps -->
        <div style="background:#f1f5f9; border:1px solid #e2e8f0; border-radius:8px; padding:18px;">
            <h3 style="font-size:16px; margin:0 0 10px; color:#0f172a;">ما الذي يمكنكم فعله الآن؟</h3>
            <ol style="margin:0; padding-right:18px; color:#334155; font-size:15px;">
                <li>يمكنكم إعادة التسجيل عبر الموقع وإكمال عملية الدفع من خلال بوابة الدفع المعتمدة.</li>
                <li>إذا واجهتم مشكلة أثناء الدفع، يرجى التواصل معنا مع تزويدنا ببيانات الحساب واسم الفعالية.</li>
            </ol>
        </div>

        <!-- Footer -->
        <div style="margin-top:22px; font-size:13px; color:#64748b; line-height:1.9;">
            <p style="margin:0;">هذه رسالة آلية لغرض الإشعار التنظيمي وضمان عدالة التسجيل. الرجاء عدم الرد مباشرة على
                هذا البريد إذا لم يكن مخصصًا للاستقبال.</p>
            <p style="margin:8px 0 0;">مع خالص التحية،<br>{{ config('app.name') }}</p>
        </div>

    </div>
</body>

</html>
