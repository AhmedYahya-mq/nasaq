<div class="relative pb-14">
    <div>
        @forelse ($membershipApplications as $membershipApplication)
            <div class="relative pl-8 max-[360px]:pl-4 border-l-2 mb-8 {{ $membershipApplication->status }}">
                <!-- النقطة المتغيرة -->
                <span
                    class="absolute -left-3 bottom-2 pending:top-2 pending:bottom-[unset] w-6 h-6 rounded-full flex items-center justify-center shadow badget pending:badget-60 light:pending:!text-[#e1a900]"
                    style="--badget-color: {{ $membershipApplication->status->color() }}">
                    <x-ui.icon :name="$membershipApplication->status->icon()"
                        fill="{{ $membershipApplication->status->isPending() ? 'none' : $membershipApplication->status->color() }}"
                        class="w-4 h-4" />
                </span>

                <!-- البطاقة -->
                <div class="rounded-lg shadow-sm border  p-5">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="font-bold text-sm">طلب #{{ $membershipApplication->id }}</h3>
                        <span
                            class="px-3 py-1 text-xs rounded-full badget approved:dark:text-white canceled:dark:text-white pending:badget-60 light:pending:!text-[#e1a900]"
                            style="--badget-color: {{ $membershipApplication->status->color() }};">
                            {{ $membershipApplication->status->label() }}
                        </span>
                    </div>

                    <div class="space-y-2 text-sm">
                        <div>
                            <span class="font-semibold">نوع العضوية:</span>
                            {{ $membershipApplication->membershipType }}
                        </div>
                        <div>
                            <span class="font-semibold">تاريخ التقديم:</span>
                            {{ $membershipApplication->created_at->locale($locale)->isoFormat('LLL') }}
                        </div>
                        @if ($membershipApplication->status->isDreft())
                            <div class="mt-3 absolute bottom-5 rtl:left-12 ltr:-right-3">
                                <a href="{{ route('client.membership.request', ['application' => $membershipApplication]) }}"
                                    class="inline-block px-2 py-1 text-sm font-medium badget-50  border rounded-md shadow-sm hover:badget-40 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                    أكمل الطلب
                                </a>
                            </div>
                        @endif
                    </div>

                    @if ($membershipApplication->admin_notes && !$membershipApplication->status->isPending())
                        <div class="mt-3 rounded-md border border-orange-400 bg-orange-400/10 p-3 text-sm">
                            <div>
                                <span class="font-semibold text-orange-500">📌 ملاحظة:</span>
                                <p class="mt-1">{{ $membershipApplication->admin_notes ?? 'لا توجد ملاحظات' }}</p>
                            </div>
                            @if ($membershipApplication->status->isRejected())
                                <div class="mt-2 flex justify-end">
                                    <a href="#"
                                        class="inline-block px-4 py-2 text-sm font-medium badget-50 badget-orange-400 light:badget-text-orange-500 border rounded-md shadow-sm hover:badget-40 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                        أعد التقديم
                                    </a>
                                </div>
                            @endif

                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center text-[var(--muted-foreground)] p-6">
                🚀 لا توجد طلبات حالياً
            </div>
        @endforelse
        <div class="mt-4">
            {{ $membershipApplications->links('pagination::tailwind') }}
        </div>
    </div>
</div>
