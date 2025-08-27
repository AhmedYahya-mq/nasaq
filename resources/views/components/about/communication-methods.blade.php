<section class="py-20 bg-gradient-to-b from-background via-background/80 to-muted/50">
    <div class="max-w-6xl mx-auto px-6">

        {{-- العنوان --}}
        <div class="text-center mb-16">
            <h2 class="text-4xl font-extrabold text-foreground tracking-tight">
                {{ __('about.communication.title') }}
            </h2>
            <p class="mt-3 text-muted-foreground text-lg">
                تواصل معنا عبر الطرق التي تناسبك ✨
            </p>
        </div>

        {{-- الشبكة --}}
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
            @foreach (__('about.communication.methods') as $method)
                <div
                    class="group relative p-6 rounded-2xl bg-white/60 dark:bg-card/60 backdrop-blur-md border border-border shadow-sm
                           hover:shadow-xl transition-all duration-300 hover:-translate-y-1"
                >
                    {{-- أيقونة --}}
                    <div class="w-14 h-14 rounded-full bg-gradient-to-br from-primary/90 to-primary flex items-center justify-center text-white shadow-md mb-5 transform group-hover:scale-110 transition">
                        {!! $method['icon'] !!}
                    </div>

                    {{-- العنوان والوصف --}}
                    <h3 class="text-xl font-semibold text-foreground mb-2">
                        {{ $method['title'] }}
                    </h3>
                    <p class="text-sm text-muted-foreground leading-relaxed">
                        {{ $method['desc'] }}
                    </p>

                    {{-- ملاحظة --}}
                    @isset($method['note'])
                        <p class="text-xs text-muted-foreground/70 mt-3 italic">
                            {{ $method['note'] }}
                        </p>
                    @endisset

                    {{-- خط زخرفي في الأسفل --}}
                    <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-2/3 h-0.5 bg-gradient-to-r from-primary/50 via-primary to-primary/50 rounded-full opacity-0 group-hover:opacity-100 transition"></span>
                </div>
            @endforeach
        </div>
    </div>
</section>
