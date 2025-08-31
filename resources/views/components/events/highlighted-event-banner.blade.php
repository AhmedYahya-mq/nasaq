@props([
    'title' => __('events.highlighted_event.default_title'),
    'date' => '2025-09-25 18:30:00',
    'location' => __('events.highlighted_event.default_location'),
    'url' => '#',
])

<div class="relative overflow-hidden rounded-3xl border border-border shadow-2xl
             from-primary/10 via-background to-accent/5
            p-10 flex flex-col md:flex-row items-center justify-between gap-8
            transition-all duration-500 hover:shadow-primary/30 hover:scale-[1.02] group">

    {{-- خلفية زخرفية متحركة --}}
    <div class="absolute inset-0 -z-10 overflow-hidden">
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-red-700/20 blur-3xl rounded-full animate-pulse"></div>
        <div class="absolute -bottom-32 -right-32 w-72 h-72 bg-accent/30 blur-2xl rounded-full animate-spin-slow"></div>
        <div class="absolute top-1/2 left-1/2 w-[120%] h-[2px] bg-red-300 from-transparent via-primary/40 to-transparent animate-move-x"></div>
    </div>

    <div class="flex flex-col items-center md:items-start text-center md:text-left space-y-5 flex-1">
        <div class="relative  bg-primary/10 p-6 rounded-2xl shadow-inner group-hover:scale-110 transition-transform duration-500">
            <h3 class="text-3xl font-extrabold tracking-tight bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent">
                {{ $title }}
            </h3>
        </div>



        <p class="text-lg text-muted-foreground leading-relaxed">
            🗓️ {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y - h:i A') }}
            📍 {{ $location }}
        </p>
    </div>

    {{-- العداد + الزر --}}
    <div class="flex flex-col items-center md:items-end text-center md:text-right space-y-8 flex-1">
        <x-events.countdown :date="$date" />

        <a href="{{ $url }}"
            class="relative px-12 py-4 font-bold text-lg rounded-xl shadow-lg overflow-hidden
                   bg-gradient-to-r from-primary to-primary/80 text-primary-foreground
                   group-hover:shadow-primary/50 transition-all duration-500
                   before:absolute before:inset-0 before:bg-gradient-to-r before:from-transparent before:via-white/20 before:to-transparent
                   before:-translate-x-full group-hover:before:translate-x-full before:transition-transform before:duration-700">
            {{ __('events.highlighted_event.register_now_button') }}
        </a>
    </div>
</div>

{{-- أنيميشن مخصص --}}
<style>
    @keyframes spin-slow {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    .animate-spin-slow {
        animation: spin-slow 25s linear infinite;
    }
    @keyframes move-x {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }
    .animate-move-x {
        animation: move-x 8s linear infinite;
    }
    @keyframes bounce-slow {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-6px); }
    }
    .animate-bounce-slow {
        animation: bounce-slow 3s infinite;
    }
</style>
