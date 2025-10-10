@props([
    'title' => __('memberships.upload.default_title'),
    'subtitle' => __('memberships.upload.default_subtitle'),
    'name' => 'file',
    'value' => null,
    'required' => false,
    'multiple' => false,
    'accepted' =>
        'image/*,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'maxSize' => '10MB',
    'maxFiles' => null, // <- هنا نضيف الحد الأعلى لعدد الملفات
])

@php
    $uploadConfig = [
        'name' => $name,
        'required' => (bool) $required,
        'multiple' => (bool) $multiple,
        'maxSize' => $maxSize,
        'accepted' => $accepted,
        'maxFiles' => $maxFiles,
        'csrf' => csrf_token(),
        'value' => old($name, $value),
        'labelIdle' =>
            "
                <div class='flex flex-col items-center justify-center p-6 text-center'>
                    <svg class='w-12 h-12 mb-3 text-primary/70' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor'>
                        <path stroke-linecap='round' stroke-linejoin='round' d='M12 16.5V9.75m0 0l-3 3m3-3l3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z' />
                    </svg>
                    <p class='text-muted-foreground text-sm'>
                        " .
                        __('memberships.upload.drop_or_click') .
                        "
                    </p>
                    <p class='text-xs text-muted-foreground mt-1'>
                        " .
                        __('memberships.upload.supported_files_detailed', ['size' => $maxSize]) .
                        "
                    </p>
                </div>
            ",

        'labelFileProcessing' => __('memberships.upload.processing'),
        'labelFileProcessingComplete' => __('memberships.upload.complete'),
        'labelTapToUndo' => __('memberships.upload.tap_to_undo'),
        'labelTapToCancel' => __('memberships.upload.tap_to_cancel'),
    ];
@endphp

<div x-data="fileUploadComponent(@js($uploadConfig))"
    class="w-full rounded-2xl border border-border shadow-sm overflow-hidden bg-card hover:shadow-lg transition-shadow duration-300">
    <div class="bg-gradient-to-b from-card/50 via-primary/5 to-accent/10 p-6 flex flex-col rounded-2xl">
        <h3 class="text-lg font-semibold text-foreground">{!! $title !!}</h3>

        @if ($subtitle)
            <p class="text-sm text-muted-foreground mt-1 text-center">{!! $subtitle !!}</p>
        @endif

        <div class="w-full mt-4 parent relative rounded-xl overflow-hidden border border-border shadow-inner min-h-28">
            <input type="file" x-ref="filepondInput" class="w-full" />


        </div>
    </div>
</div>
