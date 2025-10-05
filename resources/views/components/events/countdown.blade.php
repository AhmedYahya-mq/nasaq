@props([
    'date' => now()->addDays(5)->format('Y-m-d H:i:s'), // وقت الفعالية المستهدف
    // مصفوفة الترجمات لتمريرها إلى JavaScript
    'translations' => [
        'days' => __('events.countdown.days'),
        'hours' => __('events.countdown.hours'),
        'minutes' => __('events.countdown.minutes'),
        'seconds' => __('events.countdown.seconds'),
    ]
])
<div
    x-data="countdown('{{ $date }}', {{ json_encode($translations) }})"
    x-init="init()"
    @destroy="destroy()"
    class="flex justify-center md:justify-start gap-3"
>
    <template x-for="(value, label) in timeParts" :key="label">
        <div class="flex flex-col items-center">
            <span
                x-text="value"
                class="text-2xl md:text-3xl font-bold text-primary bg-primary/10 px-4 py-2 rounded-xl shadow-sm border border-primary/20"
            ></span>
            <span class="text-sm md:text-lg text-muted-foreground mt-1" x-text="label"></span>
        </div>
    </template>
</div>
