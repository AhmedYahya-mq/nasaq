@props([
    'title' => 'رفع المستندات',
    'subtitle' => 'يرجى رفع المستندات المطلوبة لإتمام التسجيل',
    'name' => 'file',
    'required' => false,
    'accepted' => 'image/*,.pdf',
    'maxSize' => '10MB',
    'multiple' => false,
    'maxFiles' => 5,
])

<div
    x-data="{
        pond: null,
        error: '',
        initFilePond(element) {
            // تسجيل الإضافات الأساسية للتصميم
            FilePond.registerPlugin(
                FilePondPluginFileValidateSize,
                FilePondPluginFileValidateType,
                FilePondPluginImagePreview
            );

            this.pond = FilePond.create(element, {
                // --- الإعدادات الأساسية ---
                name: '{{ $multiple ? $name . '[]' : $name }}',
                required: {{ $required ? 'true' : 'false' }},
                allowMultiple: {{ $multiple ? 'true' : 'false' }},
                maxFiles: {{ $multiple ? $maxFiles : 1 }},
                maxFileSize: '{{ $maxSize }}',
                acceptedFileTypes: '{{ $accepted }}'.split(','),
                credits: false,

                // --- تصميم الواجهة والترجمة ---
                labelIdle: `
                    <div class='flex flex-col items-center justify-center p-6 text-center'>
                        <div class='mb-4 rounded-full bg-primary/10 p-3'>
                            <svg class='w-10 h-10 text-primary' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='currentColor'><path d='M13 12.4142L15.8284 15.2426L14.4142 16.6568L12 14.2426L9.58579 16.6568L8.17157 15.2426L11 12.4142V3H13V12.4142ZM5.75736 15.2426L2 19V21H22V19L18.2426 15.2426L14.4142 19.0711L12 16.6568L5.75736 10.4142L2 14.1716V4C2 3.44772 2.44772 3 3 3H21C21.5523 3 22 3.44772 22 4V14.1716L18.2426 10.4142L12 16.6568L9.58579 14.2426L5.75736 18.0711V15.2426Z'></path></svg>
                        </div>
                        <span class='font-semibold text-foreground'>اسحب وأفلت ملفاتك هنا</span>
                        <p class='text-sm text-muted-foreground mt-1'>أو <span class='filepond--label-action text-primary font-medium'>تصفح جهازك</span></p>
                        <p class='text-xs text-muted-foreground/80 mt-3'>الأنواع المسموحة: {{ str_replace(',', ', ', $accepted  ) }} (بحد أقصى {{ $maxSize }})</p>
                    </div>
                `,

                // --- معالجة الأخطاء في الواجهة ---
                onaddfilestart: (file) => { this.error = ''; }, // إخفاء الخطأ عند بدء رفع جديد
                onerror: (error) => {
                    this.error = error.body || 'لا يمكن رفع هذا الملف. تحقق من النوع والحجم.';
                },
            });
        }
    }"
    x-init="initFilePond($refs.filepondInput)"
    class="w-full bg-card border border-border rounded-2xl shadow-sm"
>
    <div class="p-6 md:p-8">
        <!-- العناوين -->
        <div class="mb-5 text-center">
            <h2 class="text-xl font-bold text-foreground">{{ $title }}</h2>
            <p class="text-sm text-muted-foreground mt-1">{{ $subtitle }}</p>
        </div>

        <!-- منطقة رفع الملفات -->
        <div class="max-w-xl mx-auto">
            <div x-ref="filepondInput"></div>
        </div>
    </div>

    {{-- شريط عرض الخطأ --}}
    <template x-if="error">
        <div class="border-t border-border bg-red-500/5 text-red-600 dark:text-red-400 p-3 text-sm font-semibold text-center">
            <span x-text="error"></span>
        </div>
    </template>
</div>

{{-- ================================================== --}}
{{-- ============  FilePond Dependencies  ============= --}}
{{-- ================================================== --}}
@once
    @push('styles')
        <link href="https://unpkg.com/filepond/dist/filepond.min.css" rel="stylesheet">
        <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css" rel="stylesheet">
        <style>
            /* تخصيص مظهر FilePond ليتناسب مع التصميم الحديث */
            .filepond--root {
                font-family: inherit;
                border: 2px dashed var(--border-color, #d1d5db ); /* استخدام متغير للون الحدود */
                border-radius: 0.75rem; /* زوايا دائرية */
                background-color: var(--bg-color, #f9fafb);
                transition: all 0.2s ease-in-out;
                margin-bottom: 0 !important; /* إزالة الهامش السفلي الافتراضي */
            }
            .filepond--panel-root {
                background-color: transparent; /* جعل اللوحة الداخلية شفافة */
            }
            /* حالة التمرير وسحب الملفات */
            .filepond--root:hover,
            .filepond--drag-hover {
                border-color: var(--primary-color, #3b82f6);
                border-style: solid;
                background-color: var(--primary-bg-hover, #eff6ff);
            }
            .filepond--label-action {
                text-decoration: underline;
                text-decoration-style: dashed;
                cursor: pointer;
            }
            /* تخصيص شريط التقدم */
            .filepond--progress-indicator {
                background-color: var(--primary-color, #3b82f6);
            }
            /* تخصيص معاينة الصور */
            .filepond--item-panel {
                border-radius: 0.5rem;
            }
            /* تعريف متغيرات الألوان لتسهيل التخصيص */
            :root {
                --border-color: #e5e7eb;
                --bg-color: #f9fafb;
                --primary-color: #3b82f6;
                --primary-bg-hover: #eff6ff;
            }
            .dark {
                --border-color: #374151;
                --bg-color: #1f2937;
                --primary-color: #60a5fa;
                --primary-bg-hover: #1e293b;
            }
        </style>
    @endpush

    @push('scripts')
        {{-- FilePond Core & Plugins --}}
        <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.min.js"></script>
        <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.min.js"></script>
        <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
        <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
    @endpush
@endonce
