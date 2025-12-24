<div class="card flex flex-col">
    <!-- صورة الملف الشخصي -->
    <div x-data="photoProfile" x-ref="progres"
        class="p-1 relative bg-background transition-all border border-muted size-[120px] aspect-square mx-auto mt-5 rounded-full grid place-items-center"
        style="background: conic-gradient(var(--primary) 0% 0%, var(--background) 0% 100%);">
        <img data-photo-profile src="{{ $user->profile_photo_url }}" width="120" height="120"
            class="size-full rounded-full overflow-hidden object-cover" alt="{{ $user->name }}">
        <label for="photo" aria-label="Change Profile Picture"
            class="absolute cursor-pointer bottom-1 -right-1 bg-card active:scale-90 transition-transform e p-2 rounded-full dark:shadow-[0_0px_15px_rgba(255,255,255,0.15)]
                                shadow-[0_0px_15px_rgba(0,0,0,0.30)]">
            <x-ui.icon name="camera" class="size-5" />
            <input type="file" id="photo" @change="updateFile($event)" style="display: none;" accept="image/*">
        </label>
        <div class="absolute inset-0 rounded-full bg-background/35" x-show="loading" x-cloak>
            <div class="w-full h-full flex items-center justify-center" role="status">
                <span class="text-sm text-foreground font-semibold" x-text="percent"></span>
            </div>
        </div>
    </div>

    <!-- معلومات العضوية -->
    <div class="text-center mt-3 mb-5">
        <h2 class="text-lg font-semibold">{{ $user->name }}</h2>
        <p class="text-sm text-muted-foreground">
            {{-- حالة العضوية --}}
            @if ($user->membership_id)
                {{ $user->membership->name }}
                <span style=" --badget-color: {{ $user->membership_status->getColor() }};"
                    class="badget px-2 py-1 rounded-md text-xs font-medium ">
                    {{ $user->membership_status->label() }}
                </span>
                <br>
                <small>{{ __('header.expires_in') }}: {{ $user->membership_expires_at->format('d/m/Y') }}</small>
            @elseif($hasDraftApplication)
                {{-- حالة الدفع ولكن لم يقدم الطلب بعد --}}
                <span class="text-sm font-medium text-primary">
                    <span>{{ $draftMembershipName ?? __('header.membership_request_draft') }}</span>
                    {{-- status --}}
                    <span class="badget badget-[#B0B0B0] px-2 py-1 rounded-md text-xs font-medium ">
                        {{ $draftApplication->status->Holded() }}
                    </span>
                </span>
            @else
                {{ __('header.membership_regular') }}
            @endif
        </p>

        <!-- زر الاشتراك / الترقية / إكمال الطلب -->
        <div class="mt-2">
            @if ($user->membership_id)
                <a href="{{ route('client.pay.index', ['id' => $user->membership->id, 'type' => 'membership']) }}"
                    class="badget hover:badget-80 transition py-1 px-3 rounded-md hover:bg-secondary/60 cursor-pointer text-sm">
                    {{ __('header.renew_membership') }}
                </a>
            @elseif (!$user->membership_id && !$hasDraftApplication)
                <a href="{{ route('client.memberships') }}"
                    class="badget hover:badget-80 transition py-1 px-3 rounded-md hover:bg-secondary/60 cursor-pointer text-sm">
                    {{ __('header.subscribe_membership') }}
                </a>
            @elseif($hasDraftApplication)
                <div class="mt-2 text-sm text-muted-foreground">
                    {{ __('header.your_request_has_not_been_submitted') }} <br>
                    <a href="{{ route('client.membership.request', ['application' => $draftApplication]) }}"
                        class="text-primary hover:underline">
                        {{ __('header.complete_request') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
