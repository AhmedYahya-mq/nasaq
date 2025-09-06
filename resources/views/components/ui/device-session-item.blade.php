<div class="flex justify-between items-center p-2">
    <div class="flex gap-3 items-center">
        <div class="size-12 badget-70  rounded flex items-center justify-center">
            <x-ui.icon :name="$session->agent['is_desktop'] ? 'system' : 'phone'" class="size-5" />
        </div>
        <div class="flex flex-col">
            <h3 class="font-semibold text-md">
                {{ $session->agent['platform'] }}, {{ $session->agent['browser'] }}
                @if ($session->is_current_device)
                    <span class="text-sm text-green-500">(هذا الجهاز)</span>
                @endif
            </h3>
            <p class="text-sm text-muted-foreground">{{ $session->ip_address }} - {{ $session->last_active }}</p>
        </div>
    </div>
</div>
