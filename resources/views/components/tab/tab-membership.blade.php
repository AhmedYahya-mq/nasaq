{{-- resources/views/components/membership-card.blade.php --}}

@props([
    'userName' => 'أحمد محمد',
    'membershipName' => 'عضوية بلاتينية',
    'memberId' => '#2024-0012',
    'joinDate' => '15/03/2024',
    'membershipStatus' => 'نشط',
    'membershipDates' => '01/01/2025 - 31/12/2025',
    'profileImage' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=500&q=80',
    'qrCode' => 'https://api.qrserver.com/v1/create-qr-code/?size=110x110&data=MemberID-2024-0012',
    'downloadable' => true,
])

@push('scripts')
    @vite(['resources/js/pages/print.js'])
    <style>
        /* البطاقة الرسمية */
        #membershipCard {
            position: relative;
            width: 700px;
            height: 400px;
            background: linear-gradient(135deg, #1a1a2e 0%, #162447 100%);
            border-radius: 10px;
            position: relative;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
            display: flex;
            overflow: hidden;
            color: white;
            font-family: 'Segoe UI', Tahoma, sans-serif;
        }

        .card-left {
            width: 40%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;

            &:where(:dir(ltr), [dir="ltr"], [dir="ltr"] *) {
                border-right: 2px solid rgba(255, 255, 255, 0.2);
            }

            &:where(:dir(rtl), [dir="rtl"], [dir="rtl"] *) {
                border-left: 2px solid rgba(255, 255, 255, 0.2);
            }
        }

        .card-right {
            width: 60%;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .profile-img-container {
            position: relative;
            margin-bottom: 25px;
        }

        .profile-img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .membership-badge {
            position: absolute;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(255, 255, 255, 0.1);
            color: #f5d547;
            padding: 4px 15px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: bold;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .qr-code {
            width: 110px;
            height: 110px;
            background: #fff;
            padding: 5px;
            border-radius: 10px;
            border: 2px solid #f5d547;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-top: 15px;
        }

        .user-name {
            font-size: 28px;
            margin-bottom: 10px;
            font-weight: 700;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        }

        .membership-type {
            font-size: 18px;
            margin-bottom: 25px;
            color: #f5d547;
            font-weight: 600;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 25px;
        }

        .info-item {
            text-align: right;
            padding: 12px 15px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .info-label {
            display: block;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 5px;
        }

        .info-value {
            display: block;
            font-size: 16px;
            font-weight: 600;
            color: #fff;
        }

        .status-active {
            color: #a5d6a7;
        }

        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
            padding-top: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            font-size: 14px;
        }

        .logo {
            font-weight: bold;
            color: #f5d547;
        }

        .card-id {
            color: rgba(255, 255, 255, 0.7);
        }
    </style>
@endpush

<div x-data="printInit" class="flex flex-col items-center w-full space-y-6">
    <!-- بطاقة العضوية -->
    <div class="scrollbar flex flex-col items-center w-full m-0 p-0">
        <div id="membershipCard" x-ref="card">
            <img src="{{ asset('favicon.ico') }}" alt="logo"
                class="absolute top-3 rtl:left-3 ltr:right-3 w-10 h-10 opacity-20">
            <div class="card-left">
                <div class="profile-img-container">
                    <img src="{{ $profileImage }}" alt="الصورة الشخصية" class="profile-img">
                </div>
                <img src="{{ $qrCode }}" alt="QR Code" class="qr-code">
            </div>

            <div class="card-right">
                <h1 class="user-name" id="userName">{{ $userName }}</h1>
                <div class="membership-type" id="membershipName">عضوية الأخصائي المرخّص</div>

                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">رقم العضوية</span>
                        <span class="info-value">{{ $memberId }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">تاريخ الإنضمام</span>
                        <span class="info-value">{{ $joinDate }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">الحالة</span>
                        <span class="info-value status-active" id="membershipStatus">{{ $membershipStatus }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">فترة العضوية</span>
                        <span class="info-value" id="membershipDates">{{ $membershipDates }}</span>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="logo">مجتمع نسق</div>
                    <div class="card-id">البطاقة شخصية وغير قابلة للتحويل</div>
                </div>
            </div>
        </div>
    </div>

    <!-- أزرار التحكم -->
    @if ($downloadable)
        <div class="flex flex-col md:flex-row items-center gap-4">
            <button @click="downloadTransparent"
                class="btn flex justify-center items-center gap-2 rtl:flex-row-reverse bg-primary/40 hover:bg-primary/30 disabled:opacity-50 py-2 px-4 rounded mt-5"
                :disabled="isLoadingPng">
                <div x-show="isLoadingPng" x-transition.opacity.duration.500ms
                    class="border-primary border-b-transparent border-4 animate-spin size-6 rounded-full"></div>
                <span> تنزيل البطاقة كصورة</span>
            </button>
            <button @click="downloadPDF"
                class="btn flex justify-center items-center gap-2 rtl:flex-row-reverse bg-primary/40 hover:bg-primary/30 disabled:opacity-50 py-2 px-4 rounded mt-5"
                :disabled="isLoadingPdf">
                <div x-show="isLoadingPdf" x-transition.opacity.duration.500ms
                    class="border-primary border-b-transparent border-4 animate-spin size-6 rounded-full"></div>
                <span> تنزيل البطاقة pdf</span>
            </button>
        </div>
    @endif

</div>
