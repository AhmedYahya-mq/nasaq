<div class="card relative overflow-hidden rounded-2xl border border-border/70 bg-gradient-to-br from-background via-background to-primary/5 shadow-xl">
    <div class="absolute inset-x-0 top-0 h-20 bg-primary/10 blur-[80px]"></div>
    <div class="flex flex-col items-center px-5 pt-6 pb-5 relative z-10">
        <div x-data="photoProfile" x-ref="progres"
            class="relative size-32 rounded-full p-[3px] bg-gradient-to-tr from-primary via-primary/60 to-accent shadow-lg">
            <div class="size-full rounded-full bg-background grid place-items-center">
                <img data-photo-profile src="{{ $user->profile_photo_url }}" width="120" height="120"
                    class="size-full rounded-full object-cover" alt="{{ $user->name }}">
            </div>
            <label for="photo" aria-label="Change Profile Picture"
                class="absolute cursor-pointer bottom-1 -right-1 bg-card border border-border active:scale-95 transition-transform p-2 rounded-full shadow-lg shadow-primary/20">
                <x-ui.icon name="camera" class="size-5" />
                <input type="file" id="photo" @change="updateFile($event)" style="display: none;" accept="image/*">
            </label>
            <div class="absolute inset-0 rounded-full bg-background/40 grid place-items-center" x-show="loading" x-cloak>
                <span class="text-sm font-semibold" x-text="percent"></span>
            </div>
        </div>

        <div class="mt-4 text-center space-y-1">
            <h2 class="text-xl font-semibold text-foreground">{{ $user->name }}</h2>
            <div class="text-sm text-muted-foreground flex items-center justify-center gap-2 flex-wrap">
                @if ($user->membership_id)
                    <span class="px-2 py-1 rounded-full bg-primary/10 text-primary font-medium text-xs">
                        {{ $user->membership->name }}
                    </span>
                    <span style="--badget-color: {{ $user->membership_status->getColor() }};"
                        class="badget px-2 py-1 rounded-full text-xs font-semibold">
                        {{ $user->membership_status->label() }}
                    </span>
                    <span class="text-xs text-muted-foreground block">
                        {{ __('header.expires_in') }}: {{ $user->membership_expires_at->format('d/m/Y') }}
                    </span>
                @elseif($hasDraftApplication)
                    <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-900 text-xs font-semibold">
                        {{ $draftMembershipName ?? __('header.membership_request_draft') }}
                    </span>
                    <span class="badget badget-[#B0B0B0] px-2 py-1 rounded-full text-xs font-medium">
                        {{ $draftApplication->status->Holded() }}
                    </span>
                @else
                    <span class="px-3 py-1 rounded-full bg-muted text-xs font-medium">{{ __('header.membership_regular') }}</span>
                @endif
            </div>
        </div>

        <div class="mt-4 flex flex-wrap items-center justify-center gap-2">
            @if ($user->membership_id)
                <a href="{{ route('client.pay.index', ['id' => $user->membership->id, 'type' => 'membership']) }}"
                    class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-sm font-semibold bg-primary text-white shadow-md hover:bg-primary/90 transition">
                     {{ __('header.renew_membership') }}
                </a>
                @if (method_exists($user->membership, 'isHigherLevelThan') && !$user->membership->isHigherLevelThan())
                    <a href="{{ route('client.memberships') }}"
                        class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-sm font-semibold border border-primary/60 text-primary hover:bg-primary/10 transition">
                        {{ __('header.upgrade_membership') }}
                    </a>
                @endif
            @elseif (!$user->membership_id && !$hasDraftApplication)
                <a href="{{ route('client.memberships') }}"
                    class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-sm font-semibold bg-primary text-white shadow-md hover:bg-primary/90 transition">
                    {{ __('header.subscribe_membership') }}
                </a>
            @elseif($hasDraftApplication)
                <div class="text-sm text-muted-foreground text-center leading-relaxed">
                    {{ __('header.your_request_has_not_been_submitted') }}<br>
                    <a href="{{ route('client.membership.request', ['application' => $draftApplication]) }}"
                        class="text-primary font-semibold hover:underline inline-flex items-center gap-1">
                        <x-ui.icon name="edit" class="size-4" /> {{ __('header.complete_request') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
