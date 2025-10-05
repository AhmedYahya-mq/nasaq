{{-- ملف: resources/views/components/ui/image-gallery.blade.php --}}
@props(['images' => []])

@php
    // توليد 20 صورة عشوائية للاختبار إذا لم يتم تمرير صور
    $sampleImages = [];
    for ($i = 0; $i < 35; $i++) {
        $height = rand(300, 600); // عرض عشوائي بين 300 و 700
        $width = rand(300, 1000); // ارتفاع عشوائي بين 300 و 1200
        $id = 100 + $i; // لتغيير الصورة في Picsum
        $sampleImages[] = "https://picsum.photos/{$width}/{$height}";
    }
    $images = array_merge($sampleImages, $images);
    $totalImages = count($images);
    $imagesPerPage = 20;
@endphp
@push('scripts')
    @vite('resources/js/pages/details-archive.js')
@endpush
@if ($totalImages)
    <div x-data="imageGallery(@js($images), {{ $imagesPerPage }})" @keydown.escape.window="isOpen = false" @keydown.arrow-right.window="lightboxNext()"
        @keydown.arrow-left.window="lightboxPrev()" class="w-full">
        {{-- شبكة الصور المصغرة --}}
        <div class="columns-1 sm:columns-2 md:columns-3 lg:columns-4 gap-4 space-y-4">
            <template x-for="(image, idx) in pagedImages" :key="idx">
                <div class="break-inside-avoid rounded-lg overflow-hidden shadow-lg cursor-pointer group"
                    @click="openLightbox(idx)">
                    <img :src="image" :alt="'صورة أرشيف رقم ' + (idx + 1 + page * imagesPerPage)"
                        class="w-full object-cover transition-transform duration-300 group-hover:scale-105"
                        loading="lazy">
                </div>
            </template>
        </div>


        {{-- أزرار التنقل بين الصفحات (فقط إذا الصور > 20) --}}
        <div class="flex rtl:flex-row-reverse justify-center items-center gap-4 mt-4"
            x-show="images.length > imagesPerPage">
            <button @click="prev()" :disabled="page === 0"
                class="px-4 py-2 rounded-full border border-border bg-card text-foreground hover:bg-primary/20 transition focus:outline focus:outline-2 focus:outline-primary disabled:opacity-50"
                aria-label="السابق">
                {{ __('Previous') }}
            </button>
            <span class="text-sm font-semibold text-muted-foreground select-none">
                <span x-text="Math.min((page+1)*imagesPerPage, images.length)"></span>
                /
                <span x-text="images.length"></span>
            </span>
            <button @click="next()" :disabled="page === pageCount() - 1"
                class="px-4 py-2 rounded-full border border-border bg-card text-foreground hover:bg-primary/20 transition focus:outline focus:outline-2 focus:outline-primary disabled:opacity-50"
                aria-label="التالي">
                {{ __('Next') }}
            </button>
        </div>

        {{-- نافذة التكبير (Lightbox) --}}
        <template x-if="isOpen">
            <div x-transition
                class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex flex-col items-center justify-center p-2 md:p-8"
                @click.self="isOpen = false" x-ref="lightbox" x-init="let startX = null;
                let threshold = 50;
                let hintDismissed = false;
                $refs.lightbox.addEventListener('touchstart', e => {
                    if (e.touches.length === 1) startX = e.touches[0].clientX;
                });
                $refs.lightbox.addEventListener('touchend', e => {
                    if (startX === null) return;
                    let endX = e.changedTouches[0].clientX;
                    let diff = endX - startX;
                    if (Math.abs(diff) > threshold) {
                        if (diff < 0) { lightboxNext(); } else { lightboxPrev(); }
                        hintDismissed = true;
                        $dispatch('dismiss-hint');
                    }
                    startX = null;
                });"
                @dismiss-hint.window="showHint = false" x-data="{ showHint: localStorage.getItem('galleryHintDismissed') !== '1' }">
                {{-- تلميح onboarding متحرك للمستخدم الجديد --}}
                <template x-if="showHint">
                    <div
                        class="absolute left-1/2 -translate-x-1/2  top-1/2 -translate-y-1/2 z-50 flex flex-col items-center pointer-events-none select-none">
                        <div class="relative flex items-center justify-center">
                            {{-- سهم يسار --}}
                            <svg class="w-8 h-8 text-primary absolute left-0 animate-arrow-left" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                            {{-- يد متحركة --}}
                            <svg class="w-12 h-12 text-gray-700 animate-hand-swipe" fill="none" viewBox="0 0 48 48">
                                <path d="M24 44c-6-2-10-8-10-14V18a4 4 0 018 0v10" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" />
                                <path d="M24 44c6-2 10-8 10-14V18a4 4 0 00-8 0v10" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" />
                                <circle cx="24" cy="14" r="4" fill="currentColor" />
                            </svg>
                            {{-- سهم يمين --}}
                            <svg class="w-8 h-8 text-primary absolute right-0 animate-arrow-right" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                        <span> اسحب يمينًا أو يسارًا للتنقل بين الصور على الجوال.</span>
                        <style>
                            @keyframes hand-swipe {
                                0% {
                                    transform: translateX(-24px);
                                }

                                30% {
                                    transform: translateX(24px);
                                }

                                60% {
                                    transform: translateX(-24px);
                                }

                                100% {
                                    transform: translateX(-24px);
                                }
                            }

                            .animate-hand-swipe {
                                animation: hand-swipe 2s infinite;
                            }

                            @keyframes arrow-left {

                                0%,
                                100% {
                                    opacity: 0;
                                    transform: translateX(0);
                                }

                                10% {
                                    opacity: 1;
                                    transform: translateX(-8px);
                                }

                                30% {
                                    opacity: 1;
                                    transform: translateX(-16px);
                                }

                                40% {
                                    opacity: 0;
                                    transform: translateX(-16px);
                                }
                            }

                            .animate-arrow-left {
                                animation: arrow-left 2s infinite;
                            }

                            @keyframes arrow-right {

                                0%,
                                60%,
                                100% {
                                    opacity: 0;
                                    transform: translateX(0);
                                }

                                70% {
                                    opacity: 1;
                                    transform: translateX(8px);
                                }

                                90% {
                                    opacity: 1;
                                    transform: translateX(16px);
                                }

                                100% {
                                    opacity: 0;
                                    transform: translateX(16px);
                                }
                            }

                            .animate-arrow-right {
                                animation: arrow-right 2s infinite;
                            }
                        </style>
                    </div>
                </template>
                {{-- زر إغلاق --}}
                <button @click="isOpen = false; showHint = false; localStorage.setItem('galleryHintDismissed','1')"
                    class="absolute top-4 right-4 bg-black/70 text-white rounded-full p-2 hover:bg-primary focus:outline focus:outline-primary"
                    aria-label="إغلاق">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                {{-- زر السابق وزر التالي --}}
                <div class="absolute inset-x-0 top-1/2 -translate-y-1/2 flex items-center justify-between px-4 md:px-8">
                    {{-- زر السابق --}}
                    <button @click.stop="lightboxPrev()"
                        class=" bg-black/70 text-white rounded-full p-2 hover:bg-primary focus:outline focus:outline-primary"
                        aria-label="السابق">
                        <x-ui.icon name="arrow-left" class="w-5 h-5 rtl:rotate-180" />
                    </button>
                    {{-- زر التالي --}}
                    <button @click.stop="lightboxNext()"
                        class=" bg-black/70 text-white rounded-full p-2 hover:bg-primary focus:outline  focus:outline-primary"
                        aria-label="التالي">
                        <x-ui.icon name="arrow-right" class="w-5 h-5 rtl:rotate-180" />
                    </button>
                </div>
                {{-- الصورة المكبرة --}}
                <div class="relative max-w-4xl max-h-[70vh] flex items-center justify-center">
                    <img :src="images[activeIndex]" :alt="'صورة أرشيف رقم ' + (activeIndex + 1)"
                        class="rounded-lg shadow-2xl object-contain w-full h-full">
                </div>
                {{-- شريط الصور المصغرة --}}
                <div class="flex items-center gap-2 mt-6 overflow-x-auto px-2">
                    <template x-for="i in [activeIndex-1, activeIndex, activeIndex+1]">
                        <template x-if="i >= 0 && i < images.length">
                            <button @click="goToImage(i)" :class="activeIndex === i ? 'ring-2 ring-primary' : ''"
                                class="w-16 h-16 rounded-lg overflow-hidden border-2 border-white focus:outline focus:outline-2 focus:outline-primary transition-all"
                                :aria-label="'صورة رقم ' + (i + 1)">
                                <img :src="images[i]" :alt="'صورة مصغرة رقم ' + (i + 1)"
                                    class="object-cover w-full h-full">
                            </button>
                        </template>
                    </template>
                </div>
            </div>
        </template>
    </div>
@endif
