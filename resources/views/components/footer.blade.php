@php
    $socials = config('socials', []);
@endphp
<footer class="bg-card p-4 sm:p-5 md:p-6 lg:p-7 flex flex-col flex-wrap gap-5">
    <div class="flex  gap-4 max-[685px]:flex-col justify-between items-center">
        <a href="/" class="flex-center gap-x-3 z-10">
            <img src="{{ asset('favicon.ico') }}" alt="Nasaq" class="size-8">
            <h3 class="text-lg font-semibold text-primary">{{ __('messages.nsasq') }}</h3>
        </a>
        <div class="flex flex-wrap justify-center space-x-4 mt-4 md:mt-0">
            <a href="{{ route('client.home') }}" class="text-muted-foreground hover:text-primary transition">الرئيسية</a>
            <a href="{{ route('client.blog') }}"
                class="text-muted-foreground hover:text-primary transition">المدونات</a>
            <a href="{{ route('client.events') }}"
                class="text-muted-foreground hover:text-primary transition">الفعاليات</a>
            <a href="{{ route('client.library') }}" class="text-muted-foreground hover:text-primary transition">المكتبة
                الرقمية</a>
            <a href="{{ route('client.archives') }}"
                class="text-muted-foreground hover:text-primary transition">الأرشيف</a>
            <a href="{{ route('client.about') }}" class="text-muted-foreground hover:text-primary transition">من نحن</a>
            <a href="{{ route('client.memberships') }}"
                class="text-muted-foreground hover:text-primary transition">العضويات</a>
        </div>
    </div>

    <div class="flex  gap-4 max-[685px]:flex-col justify-between items-center">
        <div class="flex flex-wrap justify-center space-x-4">
            @foreach ($socials as $social)
                @if (!empty($social['url']) && $social['url'] !== '#')
                    <a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer"
                        class="hover:scale-110 p-1 border border-primary rounded-sm transition"
                        aria-label="{{ ucfirst($social['env_key']) }}">
                        <x-ui.icon :name="$social['icon']" class="size-5 fill-primary" />
                    </a>
                @endif
            @endforeach
        </div>
        <div class="text-muted-foreground text-sm" dir="{{ $locale === 'ar' ? 'ltr' : 'rtl' }}">
            &copy; {{ date('Y') }} {{ __('footer.copyright') }}
            <a href="/" class="font-semibold hover:text-primary">{{ __('messages.nsasq') }}</a>
        </div>
    </div>
</footer>
