<article
    {{ $attributes->merge([
        'class' =>
            'relative w-full bg-card rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden group cursor-pointer transform hover:-translate-y-1 border border-border',
    ]) }}
    itemscope itemtype="http://schema.org/Event"
    aria-label="{{ $event->title }}">
    <!-- الخلفية المتدرجة -->
    <div class="absolute inset-0 bg-gradient-to-br from-background/50 via-card to-primary/5 opacity-80"></div>

    <!-- شارة الفئة -->
    <div class="absolute top-4 ltr:right-4 rtl:left-4 z-20">
        @php
            $badgeColor = $event->event_type->isVirtual()
                ? $event->event_method->color()
                : $event->event_category->color();
            $badgeLabel = $event->event_type->isVirtual()
                ? $event->event_method->label()
                : $event->event_category->label();
        @endphp
        <span
            class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold text-white shadow-lg transform rotate-3"
            style="background: linear-gradient(135deg, {{ $badgeColor }}, {{ $badgeColor }});" itemprop="eventType">
            {{ $badgeLabel }}
        </span>
    </div>

    <div class="relative z-10 p-6">
        <!-- الهيدر -->
        <header class="flex items-start justify-between mb-4">
            <h2 class="text-2xl font-bold text-card-foreground leading-tight group-hover:text-primary transition-colors duration-300 pr-12"
                itemprop="name">
                {{ $event->title }}
            </h2>
            <meta itemprop="description" content="{{ $event->description }}">
        </header>

        <!-- عداد التسجيل المدمج -->
        <section class="mb-6">
            @php
                $registered = $event->registrations_count ?? 0;
                $capacity = $event->capacity;
                $isUnlimited = empty($capacity) || $capacity == 0;

                if (!$isUnlimited) {
                    $percentage = min(100, max(0, ($registered / $capacity) * 100));
                    $remaining = $capacity - $registered;
                }
            @endphp

            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 bg-green-500 rounded-full" aria-hidden="true"></div>
                        <span class="text-sm font-semibold text-muted-foreground">مسجلون</span>
                    </div>
                    <span class="text-lg font-bold text-card-foreground"
                        itemprop="attendeeCount">{{ $registered }}</span>
                </div>
                <div class="text-right">
                    @if ($isUnlimited)
                        <div class="flex items-center gap-2 bg-green-100 dark:bg-green-900/30 px-3 py-1 rounded-full">
                            <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="currentColor"
                                viewBox="0 0 20 20" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="text-sm font-bold text-green-700 dark:text-green-400">غير محدود</span>
                        </div>
                    @else
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-muted-foreground">المتبقي</span>
                            <span
                                class="text-lg font-bold {{ $remaining <= 10 ? 'text-red-600 dark:text-red-400' : 'text-primary' }}">
                                {{ $remaining }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>
            @if (!$isUnlimited)
                <div class="w-full bg-muted rounded-full h-3 overflow-hidden" aria-label="نسبة التسجيل">
                    <div class="h-3 rounded-full bg-gradient-to-r from-green-400 to-primary transition-all duration-1000 ease-out"
                        style="width: {{ $percentage }}%"></div>
                </div>
            @endif
        </section>

        <!-- أنواع العضويات المسموحة - تصميم مضغوط -->
        @if (isset($membership_names) && count($membership_names) > 0)
            <section class="mb-4" aria-label="العضويات المسموحة">
                <!-- زر عرض العضويات -->
                <button onclick="toggleMemberships(this)"
                    class="flex items-center gap-2 w-full p-2 rounded-lg hover:bg-primary/5 transition-colors duration-200 group/member"
                    aria-expanded="false" aria-controls="membership-list">
                    <div class="flex items-center gap-2 flex-1">
                        <div class="w-6 h-6 bg-primary/10 rounded-lg flex items-center justify-center">
                            <svg class="w-3 h-3 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-card-foreground">العضويات المسموحة</span>
                        <span
                            class="text-xs bg-primary text-primary-foreground px-2 py-0.5 rounded-full">{{ count($membership_names) }}</span>
                    </div>
                    <svg class="w-4 h-4 text-muted-foreground transform transition-transform duration-200 group-hover/member:rotate-180"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <!-- قائمة العضويات - مخفية افتراضياً -->
                <div id="membership-list" class="membership-list hidden mt-2 pl-8">
                    <div class="flex flex-wrap gap-1 max-h-28 scrollbar">
                        @foreach ($membership_names as $membership)
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-primary/10 text-primary border border-primary/20">
                                {{ $membership }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- معلومات الحدث في شبكة -->
        <section class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <!-- التاريخ -->
            <div class="flex items-center gap-3 p-3 bg-card rounded-xl shadow-sm border border-border"
                itemprop="startDate" content="{{ $event->start_at->toIso8601String() }}">
                <div class="flex-shrink-0 w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <div class="text-xs text-muted-foreground">التاريخ</div>
                    <time class="text-sm font-semibold text-card-foreground"
                        datetime="{{ $event->start_at->toDateString() }}">
                        {{ $event->start_at->locale(app()->getLocale())->translatedFormat('d F Y') }}
                    </time>
                </div>
            </div>
            <!-- الوقت -->
            <div class="flex items-center gap-3 p-3 bg-card rounded-xl shadow-sm border border-border">
                <div class="flex-shrink-0 w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <div class="text-xs text-muted-foreground">الوقت</div>
                    <time class="text-sm font-semibold text-card-foreground"
                        datetime="{{ $event->start_at->setTimezone('Asia/Riyadh')->format('H:i') }}">
                        {{ $event->start_at->setTimezone('Asia/Riyadh')->locale(app()->getLocale())->translatedFormat('h:i A') }}
                    </time>
                </div>
            </div>
            <!-- الموقع -->
            @if ($event->event_type->isPhysical())
                <div class="flex items-center gap-3 p-3 bg-card rounded-xl shadow-sm border border-border md:col-span-2"
                    itemprop="location" itemscope itemtype="http://schema.org/Place">
                    <div class="flex-shrink-0 w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="text-xs text-muted-foreground">الموقع</div>
                        <div class="text-sm font-semibold text-card-foreground line-clamp-1" itemprop="address">
                            {{ $event->address }}
                        </div>
                    </div>
                </div>
            @endif
        </section>

        <!-- الوصف -->
        <section class="mb-6">
            <p class="text-muted-foreground leading-relaxed line-clamp-2 text-sm" itemprop="description">
                {{ $event->description }}
            </p>
        </section>

        <!-- زر التسجيل -->
        <footer class="flex items-center justify-between pt-4 border-t border-border">
            @if ($event->canUserRegister())
                @if (!$isRegistration)
                    @if ($event->isFull())
                        <div
                            class="flex-1 cursor-not-allowed bg-destructive text-white py-3 px-6 rounded-xl font-bold text-sm text-center"
                            aria-label="{{ __('events.labels.registration_closed') }}">
                            {{ __('events.labels.registration_closed') }}
                        </div>
                    @elseif ($event->isFree())
                        <!-- تسجيل مجاني -->
                        <a href="{{ route('client.event.register', ['event' => $event]) }}"
                            class="flex-1 bg-primary hover:bg-primary/90 text-primary-foreground py-3 px-6 rounded-xl font-bold text-sm hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 text-center"
                            itemprop="url" rel="noopener noreferrer">
                            {{ __('events.buttons.free_registration') }}
                        </a>
                    @else
                        <!-- تسجيل مدفوع -->
                        <div class="flex-1 flex items-center justify-between gap-4">
                            <a href="{{ route('client.event.register', ['event' => $event]) }}" target="_blank"
                                class="flex-1 bg-primary hover:bg-primary/90 text-primary-foreground py-3 px-6 rounded-xl font-bold text-sm hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 text-center"
                                itemprop="url" rel="noopener noreferrer">
                                💳 {{ __('events.buttons.pay_registration') }}
                            </a>
                            <div class="text-right" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                @if ($event->isDiscounted())
                                    <div class="text-xs text-muted-foreground line-through">
                                        <span>{{ $event->price }}</span>
                                        <x-ui.icon name="riyal" class="w-3 h-3 inline-block" />
                                    </div>
                                @endif
                                <div class="text-lg font-bold text-card-foreground">
                                    <span itemprop="price">{{ $event->final_price }}</span>
                                    <x-ui.icon name="riyal" class="w-4 h-4 inline-block" />
                                    <meta itemprop="priceCurrency" content="SAR" />
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    <!-- مسجل بالفعل -->
                    <div
                        class="flex-1 bg-muted text-muted-foreground py-3 px-6 rounded-xl font-bold text-sm text-center"
                        aria-label="{{ __('events.labels.already_registered') }}">
                        ✅ {{ __('events.labels.already_registered') }}
                    </div>
                @endif
            @else
                <!-- يتطلب عضوية -->
                <div
                    class="flex-1 bg-destructive hover:bg-destructive/90 text-white py-3 px-6 rounded-xl font-bold text-sm text-center"
                    aria-label="{{ __('events.labels.membership_required') }}">
                    🔒 {{ __('events.labels.membership_required') }}
                </div>
            @endif
        </footer>
    </div>

    <!-- تأثير زاوية ملونة -->
    <div class="absolute ltr:right-0 rtl:left-0 top-0  w-16 h-16">
        <div class="absolute top-0 left-0 w-16 h-16 bg-primary/20 rounded-br-2xl"></div>
    </div>
</article>
