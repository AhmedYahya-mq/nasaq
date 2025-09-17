<section id="hero">
    <div
        class="relative overflow-hidden grid grid-cols-1 place-items-center place-content-center gap-4 p-4 bg-card h-[calc(100dvh-6.9rem)]">
        <div>
            <div class="absolute inset-0 bg-gradient-to-b from-primary/50 via-primary/70 to-primary/95 opacity-90"></div>
        </div>
        @php
            $count = 250; // عدد الأيقونات
            $iconSize = 36; // تقريبا = size-9 في Tailwind (9 * 4px)
            $width = 1920; // عرض الـ div (px)
            $height = 500; // ارتفاع الـ div (px)

            $positions = [];

            for ($i = 0; $i < $count; $i++) {
                $tries = 0;
                do {
                    $x = rand(0, $width - $iconSize);
                    $y = rand(0, $height - $iconSize);

                    $overlap = false;
                    foreach ($positions as $pos) {
                        $dx = $pos['x'] - $x;
                        $dy = $pos['y'] - $y;
                        $distance = sqrt($dx * $dx + $dy * $dy);
                        if ($distance < $iconSize) {
                            $overlap = true;
                            break;
                        }
                    }

                    $tries++;
                    if ($tries > 200) {
                        $overlap = false; // عشان ما يعلق
                    }
                } while ($overlap);

                $positions[] = [
                    'x' => $x,
                    'y' => $y,
                    'icon' => rand(1, 15),
                ];
            }
        @endphp

        <div class="absolute overflow-hidden"
            style="width: {{ $width }}px; height: {{ $height }}px;">
            @foreach ($positions as $pos)
                <div class="absolute" style="left: {{ $pos['x'] }}px; top: {{ $pos['y'] }}px;">
                    <x-ui.icon name="fruits.{{ $pos['icon'] }}" class="size-9 sm:size-7 !stroke-card *:!stroke-card **:!stroke-card !fill-card animate-spin-slow" />
                </div>
            @endforeach
        </div>

        <div class="flex items-center justify-center *:not-first:p-2 overflow-hidden absolute z-10  inset-0
        ">
            <img src="{{ asset('images/نسق.min.svg') }}" class="size-auto" alt="{{ config('app.name') }}">
        </div>
        <div class="flex flex-col relative z-20 md:max-w-[50%] items-center justify-center p-5 h-full">
            <h1 class="sm:text-3xl text-2xl dark:text-white text-black font-bold mb-4">{{ __('home.hero.title') }}</h1>
            <p class="sm:text-lg text-md font-medium dark:text-white/90 text-black/80 mb-6">
                {{ __('home.hero.description') }}
            </p>
            <button aria-label="{{ __('home.hero.cta') }}"
                class="group relative overflow-hidden bg-primary !text-white px-4 py-2 rounded-lg">
                <a class="text-white" href="{{ '/' }}">{{ __('home.hero.cta') }}</a>

                <!-- لمعة -->
                <span
                    class="absolute top-0 left-[-75%] w-[50%] h-full
               bg-gradient-to-r from-transparent via-white/40 to-transparent
               rotate-12
               transition-all duration-700
               group-hover:left-[125%]">
                </span>
            </button>

        </div>
    </div>
</section>
