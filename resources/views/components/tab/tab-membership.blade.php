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
] )

{{-- 
    ========================================================
    لا تغيير هنا - الكود سليم وممتاز
    ========================================================
--}}
<div x-data="printInit"
    class="flex flex-col items-center w-full space-y-6">

    <!-- بطاقة العضوية -->
    <div 
        x-ref="card"
        class="flex w-[700px] h-[400px] text-white rounded-2xl overflow-hidden shadow-2xl relative bg-gradient-to-br from-indigo-600 via-indigo-500 to-purple-400 select-none"
    >
        {{-- ... بقية كود البطاقة يبقى كما هو ... --}}
        <div class="w-2/5 flex flex-col items-center justify-center p-6 border-l border-white/30"><div class="relative mb-6"><img src="{{ $profileImage }}" alt="الصورة الشخصية" class="w-36 h-36 rounded-full border-4 border-white object-cover shadow-lg"><div class="absolute -bottom-3 left-1/2 -translate-x-1/2 bg-white/20 backdrop-blur-sm text-white text-sm font-bold border border-white/30 px-4 py-1 rounded-full">عضو {{ $membershipStatus }}</div></div><img src="{{ $qrCode }}" alt="QR Code" class="w-28 h-28 bg-white p-2 rounded-xl shadow-md"></div>
        <div class="w-3/5 p-6 flex flex-col justify-center"><h1 class="text-3xl font-bold mb-2 drop-shadow-sm">{{ $userName }}</h1><div class="text-lg text-yellow-300 font-semibold mb-6">{{ $membershipName }}</div><div class="grid grid-cols-2 gap-4 mb-6"><div class="p-3 rounded-lg bg-white/15 border border-white/20 backdrop-blur-sm"><span class="block text-xs text-white/80 mb-1">رقم العضوية</span><span class="block text-base font-semibold">{{ $memberId }}</span></div><div class="p-3 rounded-lg bg-white/15 border border-white/20 backdrop-blur-sm"><span class="block text-xs text-white/80 mb-1">تاريخ الانضمام</span><span class="block text-base font-semibold">{{ $joinDate }}</span></div><div class="p-3 rounded-lg bg-white/15 border border-white/20 backdrop-blur-sm"><span class="block text-xs text-white/80 mb-1">الحالة</span><span class="block text-base font-semibold text-green-200">{{ $membershipStatus }}</span></div><div class="p-3 rounded-lg bg-white/15 border border-white/20 backdrop-blur-sm"><span class="block text-xs text-white/80 mb-1">فترة العضوية</span><span class="block text-base font-semibold">{{ $membershipDates }}</span></div></div><div class="flex justify-between items-center border-t border-white/30 pt-3"><span class="font-semibold">نادي المحترفين</span><span class="text-sm text-white/70">البطاقة شخصية وغير قابلة للتحويل</span></div></div>
    </div>

    <!-- أزرار التحكم -->
    @if ($downloadable)
        <div class="flex justify-center gap-3 mt-4">
            <button @click="downloadTransparent"
                    class="flex items-center gap-2 px-5 py-2.5 rounded-full bg-white text-indigo-700 font-semibold shadow-md hover:shadow-lg hover:-translate-y-0.5 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="currentColor" viewBox="0 0 16 16"><path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zM1 8a7 7 0 0 1 7-7v14a7 7 0 0 1-7-7z"/></svg>
                تحميل البطاقة بدون خلفية
            </button>
        </div>
    @endif
</div>

{{-- 
    ========================================================
    بداية التغيير: استبدال @push بـ @once مع <script>
    ========================================================
--}}
@once
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
@endonce
