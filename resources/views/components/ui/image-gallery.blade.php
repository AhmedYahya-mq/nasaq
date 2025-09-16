{{-- ملف: resources/views/components/ui/image-gallery.blade.php --}}
@props(['images' => []])

@if(!empty($images))
<div
    x-data="{
        isOpen: false, // (مخفية افتراضيًا) هل نافذة التكبير مفتوحة؟
        activeIndex: 0, // ما هي الصورة المعروضة حاليًا في وضع التكبير؟

        // هذه الدالة هي التي تفتح وتكبر الصورة
        openLightbox(index) {
            this.activeIndex = index; // حدد الصورة التي تم النقر عليها
            this.isOpen = true;      // افتح نافذة التكبير
        },

        // دوال للتنقل لليمين واليسار داخل وضع التكبير
        next() { /* ... */ },
        prev() { /* ... */ }
    }"
    @keydown.escape.window="isOpen = false"
    @keydown.arrow-right.window="next()"
    @keydown.arrow-left.window="prev()"
>
    {{-- 1. هنا شبكة الصور المصغرة التي تظهر في الصفحة --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($images as $index => $image)
            @php
                // ... نفس منطق التصميم الشبكي الأنيق ...
                $pattern = [ 'large', 'small', 'small', 'portrait', 'small', 'landscape', 'small', 'small', 'portrait', 'small' ];
                $currentPattern = $pattern[$index % count($pattern)];
                $spanClasses = '';
                switch ($currentPattern) {
                    case 'large': $spanClasses = 'col-span-2 row-span-2'; break;
                    case 'portrait': $spanClasses = 'col-span-1 row-span-2'; break;
                    case 'landscape': $spanClasses = 'col-span-2 row-span-1'; break;
                    default: $spanClasses = 'col-span-1 row-span-1'; break;
                }
            @endphp


            <div
                class="{{ $spanClasses }} rounded-xl overflow-hidden shadow-lg group relative cursor-pointer"
                @click="openLightbox({{ $index }})"
            >
                <img src="{{ $image }}" alt="..." class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all duration-300"></div>
            </div>
        @endforeach
    </div>

    {{-- 2. هنا نافذة التكبير (Lightbox) - تكون مخفية --}}
    <template x-if="isOpen">
        <div
            x-transition {{-- لإضافة تأثير دخول وخروج ناعم --}}
            class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4"
            @click.self="isOpen = false"
        >
            <button @click="prev()" class="absolute left-4 ...">...</button>
            <button @click="next()" class="absolute right-4 ...">...</button>
            <button @click="isOpen = false" class="absolute top-4 right-4 ...">...</button>

            {{-- حاوية الصورة المكبرة --}}
            <div class="relative max-w-4xl max-h-[80vh]">
                
                <img :src="'{{ implode("','", $images) }}'.split(',')[activeIndex]" class="rounded-lg shadow-2xl object-contain w-full h-full">
            </div>
        </div>
    </template>
</div>
@endif
