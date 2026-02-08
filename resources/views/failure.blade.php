<x-layouts.auth title="{{ __('payments.Pay') }}">
    <div class="min-h-screen p-4 flex items-center justify-center">
        <div class="w-full max-w-lg border bg-card/50 p-6 rounded-lg shadow-lg">
            <h1 class="text-lg font-semibold mb-2">{{ __('payments.Payment failed') }}</h1>
            <p class="text-sm text-muted-foreground">
                {{ request('message') ?? __('payments.Please try again.') }}
            </p>
            <div class="mt-4">
                <a class="underline" href="{{ route('client.profile') }}">{{ __('Back to profile') }}</a>
            </div>
        </div>
    </div>
</x-layouts.auth>
