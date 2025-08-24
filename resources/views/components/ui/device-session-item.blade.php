@props([
    'deviceName' => 'Unknown Device',
    'location' => 'Unknown Location',
    'datetime' => '',
    'icon' => 'system',
    'isCurrent' => false, // تمييز الجهاز الحالي
])

<div class="flex justify-between items-center p-2">
    <div class="flex gap-3 items-center">
        <div class="size-12 badget-70  rounded flex items-center justify-center">
            <x-ui.icon :name="$icon" class="size-5" />
        </div>
        <div class="flex flex-col">
            <h3 class="font-semibold">{{ $deviceName }} @if ($isCurrent)
                    <span class="text-sm text-green-500">(هذا الجهاز)</span>
                @endif
            </h3>
            <p class="text-sm text-muted-foreground">{{ $location }} - {{ $datetime }}</p>
        </div>
    </div>
    <button aria-label="تسجيل الخروج" class="text-sm font-medium cursor-pointer">
        تسجيل الخروج
    </button>
</div>
