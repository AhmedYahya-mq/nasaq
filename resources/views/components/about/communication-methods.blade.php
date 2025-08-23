<section class="py-16 bg-background">
    <div class="max-w-5xl mx-auto px-5">
        <h2 class="text-3xl font-bold text-center text-foreground mb-12">
            {{ __('about.communication.title') }}
        </h2>
        <div class="space-y-8">
            @foreach (__('about.communication.methods') as $method)
                <div class="flex gap-x-5 p-5 bg-card rounded-xl border border-border">
                    <div class="flex-shrink-0 w-12 h-12 bg-primary/10 text-primary flex-center rounded-lg">
                        {!! $method['icon'] !!}
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-foreground">{{ $method['title'] }}</h3>
                        <p class="text-muted-foreground mt-1">{{ $method['desc'] }}</p>
                        @isset($method['note'])
                            <p class="text-xs text-muted-foreground/80 mt-2 italic">({{ $method['note'] }})</p>
                        @endisset
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
