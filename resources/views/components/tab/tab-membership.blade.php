@push('scripts')
    @vite(['resources/js/pages/print.js'])
    <style>
        /* البطاقة الرسمية */
        #membershipCard {
            position: relative;
            width: 700px;
            height: 400px;
            background: white;
            border-radius: 10px;
            position: relative;
            padding: 25px;
            box-shadow: 0 5px 15px #00000026;
            display: flex;
            overflow: hidden;
            color: #5f652c;
            font-family: 'Segoe UI', Tahoma, sans-serif;
        }

        .card-left {
            width: 40%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            border-left: 2px solid #00000033;
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
            box-shadow: 0 2px 5px #0000001a;
        }

        .membership-badge {
            position: absolute;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.1);
            color: #5f652c;
            padding: 4px 15px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: bold;
            border: 1px solid #00000033;
        }

        .qr-code {
            width: 110px;
            height: 110px;
            background: #fff;
            padding: 5px;
            border-radius: 10px;
            border: 2px solid #5f652c;
            box-shadow: 0 2px 5px #0000001a;
            margin-top: 15px;
        }

        .user-name {
            font-size: 20px;
            margin-bottom: 10px;
            font-weight: 700;
            text-shadow: 1px 1px 2px #00000033;
        }

        .membership-type {
            font-size: 16px;
            margin-bottom: 25px;
            color: #5f652c;
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
            background: rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            border: 1px solid #00000033;
        }

        .info-label {
            display: block;
            font-size: 12px;
            color: #000000b3;
            margin-bottom: 5px;
        }

        .info-value {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #5f652c;
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
            border-top: 1px solid #00000033;
            font-size: 14px;
        }

        .logo {
            font-weight: bold;
            color: #5f652c;
        }

        .card-id {
            color: #000000b3;
        }
    </style>
@endpush
<div>
    <div  class="flex flex-col items-center w-full space-y-6">
        <!-- بطاقة العضوية -->
        <div dir="rtl" class="scrollbar flex flex-col items-center w-full m-0 p-0">
            <div id="membershipCard">
                <img src="{{ asset('favicon.ico') }}" alt="{{ __(config('app.name')) }}"
                    class="absolute top-3 rtl:left-3 ltr:right-3 w-10 h-10 opacity-20">
                <div class="card-left">
                    <div class="profile-img-container">
                        <img data-photo-profile src="{{ $user->profile_photo_url }}" alt="{{ $user->english_name }}"
                            class="profile-img">
                    </div>
                    <img src="{{ $user->profileQrCodePng() }}" alt="QR Code" class="qr-code">
                </div>

                <div class="card-right">
                    <h1 class="user-name rtl:rtl rtl:text-right ltr:text-left" id="userName">{{ $user->getTranslatedName('en') }}</h1>
                    <div class="membership-type rtl:rtl rtl:text-right ltr:text-left" id="membershipName">
                        {{ $user->getMembershipNameAttribute('en') }}</div>

                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">رقم العضو</span>
                            <span class="info-value">{{ $user->id }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">تاريخ الإنضمام</span>
                            <span class="info-value">{{ $user->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">الحالة</span>
                            <span class="info-value status-active"
                                id="membershipStatus">{{ $user->membership_status->getLabel() }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">فترة العضوية</span>
                            <span class="info-value"
                                id="membershipDates">{{ $user->membership_started_at->format('d/m/Y') . ' - ' . $user->membership_expires_at->format('d/m/Y') }}</span>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="">مجتمع نسق</div>
                        <div class="">بطاقة عضوية وغير قابلة للتحويل</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col md:flex-row items-center gap-4">
            <a href="{{ route('client.print.card', ['format' => 'image']) }}" target="_self">
                <button
                    class="btn flex justify-center items-center gap-2 rtl:flex-row-reverse bg-primary/40 hover:bg-primary/30 disabled:opacity-50 py-2 px-4 rounded mt-5">
                    <div x-show="isLoadingPng" x-transition.opacity.duration.500ms
                        class="border-primary border-b-transparent border-4 animate-spin size-6 rounded-full"></div>
                    <span> تنزيل البطاقة كصورة</span>
                </button>
            </a>
            <a href="{{ route('client.print.card', ['format' => 'pdf']) }}" target="_self">
                <button
                    class="btn flex justify-center items-center gap-2 rtl:flex-row-reverse bg-primary/40 hover:bg-primary/30 disabled:opacity-50 py-2 px-4 rounded mt-5">
                    <div x-show="isLoadingPdf" x-transition.opacity.duration.500ms
                        class="border-primary border-b-transparent border-4 animate-spin size-6 rounded-full"></div>
                    <span> تنزيل البطاقة pdf</span>
                </button>
            </a>
        </div>
    </div>

    <x-membership.Certificate-hostinger-style :user="$user" />

</div>
