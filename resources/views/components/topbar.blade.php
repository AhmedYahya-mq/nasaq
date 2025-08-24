<div
    class="text-[15px] mb-0.5 inset-0 flex-center bg-card h-[45px] flex items-center justify-between max-[450px]:justify-center w-full py-3 px-1">
    <div class="flex items-center gap-4 max-[450px]:hidden">
        <div class="flex items-center gap-0.5">
            <x-ui.icon name="phone" class="size-4 text-accent-foreground" />
            <span class="text-sm text-accent-foreground"><a
                    href="tel:{{ config('content.phone') }}">{{ config('content.phone') }}</a></span>
        </div>
        <div class="flex items-center gap-1">
            <x-ui.icon name="mail" class="size-4 text-accent-foreground" />
            <span class="text-sm text-accent-foreground">
                <a href="mailto:{{ config('content.email') }}">{{ config('content.email') }}</a>
            </span>
        </div>
    </div>
    <div class="flex items-center gap-4">
        <x-ui.theme-switcher />
        <x-ui.lang-selector />
    </div>
</div>
