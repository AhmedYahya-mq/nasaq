<footer class="bg-card p-4 sm:p-5 md:p-6 lg:p-7 flex flex-col flex-wrap gap-5">
    <div class="flex  gap-4 max-[685px]:flex-col justify-between items-center">
        <a href="/" class="flex-center gap-x-3 z-10">
            <img src="{{ asset('favicon.ico') }}" alt="Nasaq" class="size-8">
            <h3 class="text-lg font-semibold text-primary">{{ __('messages.nsasq') }}</h3>
        </a>
        <div class="flex space-x-4 mt-4 md:mt-0">
            <a href="{{ route('client.home') }}" class="text-muted-foreground hover:text-primary transition">الرئيسية</a>
            <a href="{{ route('client.blog') }}" class="text-muted-foreground hover:text-primary transition">المدونات</a>
            <a href="{{ route('client.events') }}" class="text-muted-foreground hover:text-primary transition">الفعاليات</a>
            <a href="{{ route('client.library') }}" class="text-muted-foreground hover:text-primary transition">المكتبة الرقمية</a>
            <a href="{{ route('client.archives') }}" class="text-muted-foreground hover:text-primary transition">الأرشيف</a>
            <a href="{{ route('client.about') }}" class="text-muted-foreground hover:text-primary transition">من نحن</a>
            <a href="{{ route('client.price') }}" class="text-muted-foreground hover:text-primary transition">العضويات</a>
        </div>
    </div>

    <div class="flex  gap-4 max-[685px]:flex-col justify-between items-center">
        <div class="flex space-x-4">
            @if (env('CONTACT_FACEBOOK'))
                <a href="{{ env('CONTACT_FACEBOOK') }}" target="_blank" class="*:fill-primary p-1 border-primary border rounded-sm hover:scale-105 transition-transform">
                    <x-icons.social.facebook-f class="size-5" />
                </a>
            @endif
            @if (env('CONTACT_TWITTER'))
                <a href="{{ env('CONTACT_TWITTER') }}" target="_blank" class="*:fill-primary p-1 border-primary border rounded-sm hover:scale-105 transition-transform">
                    <x-icons.social.x-twitter class="size-5" />
                </a>
            @endif
            @if (env('CONTACT_INSTAGRAM'))
                <a href="{{ env('CONTACT_INSTAGRAM') }}" target="_blank" class="*:fill-primary p-1 border-primary border rounded-sm hover:scale-105 transition-transform">
                    <x-icons.social.instagram class="size-5 " />
                </a>
            @endif
            @if (env('CONTACT_LINKEDIN'))
                <a href="{{ env('CONTACT_LINKEDIN') }}" target="_blank" class="*:fill-primary p-1 border-primary border rounded-sm hover:scale-105 transition-transform">
                    <x-icons.social.linkedin-in class="size-5" />
                </a>
            @endif
            @if (env('CONTACT_YOUTUBE'))
                <a href="{{ env('CONTACT_YOUTUBE') }}" target="_blank" class="*:fill-primary p-1 border-primary border rounded-sm hover:scale-105 transition-transform">
                    <x-icons.social.youtube class="size-5" />
                </a>
            @endif
            @if (env('CONTACT_WHATSAPP'))
                <a href="{{ env('CONTACT_WHATSAPP') }}" target="_blank" class="*:fill-primary p-1 border-primary border rounded-sm hover:scale-105 transition-transform">
                    <x-icons.social.whatsapp class="size-5" />
                </a>
            @endif
            @if (env('CONTACT_TELEGRAM'))
                <a href="{{ env('CONTACT_TELEGRAM') }}" target="_blank" class="*:fill-primary p-1 border-primary border rounded-sm hover:scale-105 transition-transform">
                    <x-icons.social.telegram class="size-5" />
                </a>
            @endif
            @if (env('CONTACT_TIKTOK'))
                <a href="{{ env('CONTACT_TIKTOK') }}" target="_blank" class="*:fill-primary p-1 border-primary border rounded-sm hover:scale-105 transition-transform">
                    <x-icons.social.tiktok class="size-5" />
                </a>
            @endif
        </div>
       <div class="text-muted-foreground text-sm" dir="{{ $locale === 'ar' ? 'ltr' : 'rtl' }}">
            &copy; {{ date('Y') }} {{ __('footer.copyright') }}
            <a href="/" class="font-semibold hover:text-primary">{{ __('messages.nsasq') }}</a>
        </div>
    </div>
</footer>
