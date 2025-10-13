@push('scripts')
    <style>
        .certificate {
            width: 297mm;
            height: 210mm;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-foreground) 100%);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
            padding: 30px 40px;
            color: #1e293b;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .child-box {
            width: 100mm;
            height: 100mm;
            position: absolute;
            top: 55mm;
            left: 98.5mm;
            display: flex;
            justify-content: center;
            align-items: center;
        }


        .certificate::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 24px;
            background: radial-gradient(circle at top center, rgba(191, 164, 95, 0.08), transparent 70%);
            z-index: 0;
        }

        .certificate * {
            position: relative;
            z-index: 1;
        }

        .logo {
            width: 95px;
            display: block;
            margin: 0 auto 25px auto;
        }



        .title {
            font-size: 30px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 20px;
            letter-spacing: 0.3px;
        }

        .title_ar {
            font-size: 30px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 20px;
        }

        .content {
            font-size: 16px;
            line-height: 1.9;
            color: #fff;
            margin-bottom: 35px;
            min-height: 110px;
        }

        .member-info {
            font-size: 15px;
            line-height: 1.8;
            color: #fff;
        }

        .info-row {
            margin-bottom: 6px;
        }

        .footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #e2e8f0;
            margin-top: 10px;
        }

        .signature img {
            height: 120px;
            opacity: 0.9;
        }

        .qr-code {
            width: 85px;
            height: 85px;
        }

        .unique-id {
            text-align: center;
            font-size: 15px;
            font-weight: 600;
            color: #fff;
            margin-top: 25px;
            letter-spacing: 0.5px;
        }

        .between {
            display: grid;
            grid-template-columns: 1fr 1fr;
            column-gap: 40px;
            margin-bottom: 20px;
        }
    </style>
@endpush

<div x-data="printInit" class="flex flex-col items-center w-full space-y-6 my-10">
    <div class="scrollbar flex flex-col items-center w-full m-0 p-0">
        <div id="certificateCard" class="relative" x-ref="card">
            <div class="child-box z-10 opacity-5">
                <img src="{{ asset('favicon.ico') }}" alt="Logo" class="aspect-square object-cover">
            </div>
            <div class="certificate">
                <!-- الشعار -->
                <img src="{{ asset('favicon.ico') }}" alt="Logo" class="logo">


                <!-- النصوص المتقابلة -->
                <div class="sides">
                    <!-- عربي -->
                    <div class="side right">
                        <div class="between">
                            <div class="title_ar" dir="rtl">شهادة عضوية</div>
                            <div class="title" dir="ltr">Membership Certificate</div>
                        </div>
                        <div class="between">
                            <div class="content text-justify" dir="rtl">
                                يمنح <strong>مجتمع نسق</strong> هذه الشهادة للعضو الموقر
                                <strong>{{ $user->getTranslatedName('ar') }}</strong>،
                                تقديرًا لانضمامه المتميز وإسهاماته الإيجابية في دعم المجتمع،
                                وتشجيعًا له على الاستمرار في رحلة التميز والعطاء.
                            </div>
                            <div class="content text-justify" dir="ltr">
                                <strong>Nasq Community</strong> proudly awards this certificate to the esteemed member
                                <strong>{{ $user->getTranslatedName('en') }}</strong>,
                                in recognition of their outstanding participation, valuable contributions to the
                                community,
                                and continued pursuit of excellence.
                            </div>
                        </div>

                        <div class="member-info">
                            <div class="between">
                                <div class="info-row" dir="rtl"><strong>الاسم:</strong>
                                    {{ $user->getTranslatedName('ar') }}
                                </div>
                                <div class="info-row" dir="ltr"><strong>Name:</strong>
                                    {{ $user->getTranslatedName('en') }}</div>
                            </div>
                            <div class="between">
                                <div class="info-row" dir="rtl"><strong>نوع العضوية:</strong>
                                    {{ $user->membership_name }}
                                </div>
                                <div class="info-row text-left" dir="ltr"><strong>Membership Type:</strong>
                                    {{ $user->getMembershipNameAttribute('en') }}
                                </div>
                            </div>
                            <div class="between">
                                <!-- التاريخ بالعربي -->
                                <div class="info-row" dir="rtl">
                                    <strong>تاريخ الانضمام:</strong>
                                    {{ $user->membership_started_at->locale('ar')->isoFormat('D MMMM YYYY') }}
                                </div>

                                <!-- التاريخ بالإنجليزي -->
                                <div class="info-row text-left" dir="ltr">
                                    <strong>Joining Date:</strong>
                                    {{ $user->membership_started_at->locale('en')->isoFormat('D MMMM YYYY') }}
                                </div>
                            </div>

                            <div class="between">
                                <div class="info-row" dir="rtl"><strong>رقم العضوية:</strong>
                                    {{ $user->member_id }}
                                </div>
                                <div class="info-row text-left" dir="ltr"><strong>Membership ID:</strong>
                                    {{ $user->member_id }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- التذييل -->
                <div class="footer">
                    <img src="{{ $user->profileQrCodePng() }}" alt="QR Code" class="qr-code">
                    <div class="signature">
                        <img src="{{ asset('nasaq.png') }}" alt="Official Stamp">
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- الأزرار -->
    <div class="flex flex-col md:flex-row items-center gap-4 no-print">
        <button @click="downloadTransparent"
            class="btn flex justify-center items-center gap-2 rtl:flex-row-reverse bg-primary/40 hover:bg-primary/30 disabled:opacity-50 py-2 px-4 rounded mt-5"
            :disabled="isLoadingPng">
            <div x-show="isLoadingPng" x-transition.opacity.duration.500ms
                class="border-primary border-b-transparent border-4 animate-spin size-6 rounded-full"></div>
            <span> تنزيل الشهادة كصورة</span>
        </button>
        <button @click="downloadPDF"
            class="btn flex justify-center items-center gap-2 rtl:flex-row-reverse bg-primary/40 hover:bg-primary/30 disabled:opacity-50 py-2 px-4 rounded mt-5"
            :disabled="isLoadingPdf">
            <div x-show="isLoadingPdf" x-transition.opacity.duration.500ms
                class="border-primary border-b-transparent border-4 animate-spin size-6 rounded-full"></div>
            <span> تنزيل الشهادة PDF</span>
        </button>
    </div>
</div>
