<div>
    <div x-data='twoFactorAuth({{ auth()->user()->two_factor_confirmed_at !== null }})' class="p-4 flex flex-col gap-4">
        <div class="flex flex-col items-end gap-3">
            <div>
                <h6 class="text-[0.875rem] font-medium mb-1" x-text="title"></h6>
                <p class="text-muted-foreground">
                    عند تفعيل المصادقة الثنائية، سيتم مطالبتك برمز آمن وعشوائي أثناء المصادقة. يمكنك استرداد هذا الرمز
                    من تطبيق Google Authenticator على هاتفك.
                </p>
            </div>
            <div x-show='enabled' data-slot="content" class="px-6 w-full">
                <div x-show="status === 'two-factor-authentication-confirm'" x-cloak class="mt-4 w-full">
                    <ol class="list-decimal list-inside space-y-6">
                        <li>افتح تطبيق المصادقة على هاتفك مثل Google Authenticator أو Microsoft Authenticator أو Authy.
                        </li>
                        <li>امسح رمز الـQR الذي يظهر لك، أو أدخل مفتاح الإعداد يدويًا إذا لم تتمكن من المسح.
                            <div class="mt-2 *:bg-white *:inline-block *:p-2">
                                <div x-html="qrCode"></div>
                            </div>
                            <div class="mt-2 flex items-center gap-2">
                                <span>مفتاح الإعداد:</span>
                                <code class="bg-background px-3 py-1 rounded-md gap-4 flex items-center">
                                    <span x-text="secretKey"></span>
                                    <button data-slot="button" @click="copyed = false; copyToClipboard(secretKey);"
                                        class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-[color,box-shadow] disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg:not([class*='size-'])]:size-4 [&amp;_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive hover:bg-accent hover:text-accent-foreground size-9 bg-background !size-2.5 cursor-pointer p-1">
                                        <template x-if="copyed">
                                            <x-ui.icon class="size-4" name="check" />
                                        </template>
                                        <template x-if="!copyed">
                                            <x-ui.icon class="size-4" name="copy" />
                                        </template>
                                    </button>
                                </code>
                            </div>
                        </li>
                        <li>أدخل الرمز المكون من 6 أرقام الذي يولده التطبيق ثم اضغط على "تأكيد".
                            <form class="mt-2 space-y-4" @submit.prevent="confirm2FA">
                                <div class="grid gap-2">
                                    <x-forms.input id="code" name="code" label='رمز التحقق'
                                        placeholder='xxx-xxx' x-ref="code" />
                                    <p x-show="codeError" x-text="codeError" class="text-sm text-destructive mt-1"></p>
                                </div>
                                <button data-slot="button" :disabled="loading"
                                    class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-[color,box-shadow] disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg:not([class*='size-'])]:size-4 [&amp;_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive bg-primary text-primary-foreground shadow-xs hover:bg-primary/90 h-9 px-4 py-2 has-[&gt;svg]:px-3"
                                    type="submit">
                                    تأكيد
                                    <div x-show="loading" x-cloak>
                                        <x-ui.loading-indicator class="size-4 border-white" />
                                    </div>
                                </button>
                            </form>
                        </li>
                    </ol>
                </div>
                <div x-show="status === 'two-factor-authentication-enabled' && showingRecoveryCodes" x-cloak
                    class="w-full">
                    <div data-slot="card-description" class="text-muted-foreground text-sm">احفظ رموز الاسترداد هذه في
                        مدير
                        كلمات مرور آمن. يمكنك استخدامها لاستعادة الوصول إلى حسابك في حال فقدان جهاز المصادقة الثنائية.
                    </div>
                    <code class="relative">
                        <ul class="px-3 py-4 bg-background rounded-md mt-4">
                            <template x-for="code in recoveryCodes" :key="code">
                                <li class="font-mono text-sm" x-text="code"></li>
                            </template>
                        </ul>
                        <div class="flex items-center gap-4 absolute top-4 left-3">
                            <button data-slot="button" @click="downloadRecoveryCodes"
                                class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-[color,box-shadow] disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg:not([class*='size-'])]:size-4 [&amp;_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive hover:bg-accent hover:text-accent-foreground size-9 bg-accent !size-2.5 cursor-pointer p-1">
                                <x-ui.icon class="size-4" name="download-rec" />
                            </button>
                            <button data-slot="button" @click="copyed = false; copyToClipboard(recoveryCodes);"
                                class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-[color,box-shadow] disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg:not([class*='size-'])]:size-4 [&amp;_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive hover:bg-accent hover:text-accent-foreground size-9 bg-accent !size-2.5 cursor-pointer p-1">
                                <template x-if="copyed">
                                    <x-ui.icon class="size-4" name="check" />
                                </template>
                                <template x-if="!copyed">
                                    <x-ui.icon class="size-4" name="copy" />
                                </template>
                            </button>
                        </div>
                    </code>
                </div>
            </div>
            <div data-slot="footer">
                <div x-show="enabled && status === 'two-factor-authentication-enabled'" x-cloak
                    class="items-center px-6 flex justify-end gap-5">
                    <button :disabled="loading || regeneration" @click="disable"
                        class="h-9 px-4 py-2 has-[&gt;svg]:px-3 bg-destructive text-white shadow-xs hover:bg-destructive/90 dark:focus-visible:ring-destructive/40 inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-[color,box-shadow] disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg:not([class*='size-'])]:size-4 [&amp;_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive"
                        type="button">
                        تعطيل
                        <div x-show="loading" x-cloak>
                            <x-ui.loading-indicator class="size-4 border-white" />
                        </div>
                    </button>
                    <button data-slot="button" :disabled="loading || regeneration" x-show="!showingRecoveryCodes"
                        x-cloak @click="getRecoveryCodes"
                        class="justify-center whitespace-nowrap rounded-md text-sm font-medium transition-[color,box-shadow] disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg:not([class*='size-'])]:size-4 [&amp;_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive border border-input bg-background shadow-xs hover:bg-accent hover:text-accent-foreground h-9 px-4 py-2 has-[&gt;svg]:px-3 flex items-center gap-2">
                        عرض رموز الاسترداد
                        <div x-show="regeneration" x-cloak>
                            <x-ui.loading-indicator class="size-4 border-primary" />
                        </div>
                    </button>
                    <button data-slot="button" :disabled="loading || regeneration" x-show="showingRecoveryCodes" x-cloak
                        @click="regenerateRecoveryCodes"
                        class="justify-center whitespace-nowrap rounded-md text-sm font-medium transition-[color,box-shadow] disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg:not([class*='size-'])]:size-4 [&amp;_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive border border-input bg-background shadow-xs hover:bg-accent hover:text-accent-foreground h-9 px-4 py-2 has-[&gt;svg]:px-3 flex items-center gap-2">
                        تجديد رموز الاسترداد
                        <div x-show="regeneration" x-cloak>
                            <x-ui.loading-indicator class="size-4 border-primary" />
                        </div>
                    </button>
                </div>
                <div x-show='!enabled && status === null' x-cloak @click="confirm = true;" data-slot="card-footer"
                    class="items-center px-6 flex justify-end">
                    <button data-slot="dialog-trigger"
                        class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-[color,box-shadow] disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg:not([class*='size-'])]:size-4 [&amp;_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive bg-primary text-primary-foreground shadow-xs hover:bg-primary/90 h-9 px-4 py-2 has-[&gt;svg]:px-3"
                        type="button" aria-haspopup="dialog" aria-expanded="false" aria-controls="radix-«rb»"
                        data-state="closed">تفعيل المصادقه الثنائية</button>
                </div>
            </div>
        </div>
        <div x-show="confirm" x-cloak @click.self="confirm = false; password = '';"
            class="fixed z-50 inset-0 backdrop-blur-[2px] bg-accent-foreground/[0.04] flex items-center justify-center">
            <form @submit.prevent="enable" class="sm:w-[80%] md:w-1/2 w-full" x-show="confirm" x-cloak
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">
                <div class="bg-card p-4 rounded-md shadow flex flex-col gap-4">
                    {{-- ادخل الباسورد من اجل اتمكين 2FA --}}
                    <h3 class="text-lg font-medium">تمكين المصادقة الثنائية (2FA)</h3>
                    <p class="text-sm text-muted-foreground">
                        لتفعيل المصادقة الثنائية وحماية حسابك، يرجى إدخال كلمة المرور الخاصة بك لتأكيد هويتك.
                    </p>
                    <div>
                        <x-forms.input-password name="password" x-model='password' id="password_enable"
                            label="كلمة المرور" placeholder="أدخل كلمة المرور" class="w-full" />
                        <p x-show="passwordError" x-text="passwordError" class="text-sm text-destructive mt-1"></p>
                    </div>
                    <div class="flex justify-end gap-2 mt-2">
                        <button type="submit" :disabled="loading"
                            class="badget-green badget-80 hover:badget-70 px-2.5 py-1.5 rounded-md">
                            تمكين
                            <div x-show="loading" x-cloak>
                                <x-ui.loading-indicator class="size-4 border-white" />
                            </div>
                        </button>
                        <button type="reset" class="badget-red badget-80 hover:badget-70 px-2.5 py-1.5 rounded-md"
                            @click="confirm = false;password = '';">
                            إلغاء
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <hr>
    <div class="mt-3">
        <div class="flex justify-between py-4 border-b border-border">
            <h2 class="text-md font-semibold">
                سجل تسجيل الدخول
            </h2>
            <span x-data @click="$store.model.show()"
                class="badget badget-red-600 cursor-pointer text-sm rounded-sm py-1 px-2">
                تسجيل الخروج لكل
            </span>
        </div>
        <div class="flex flex-col gap-3 py-5 scrollbar !overflow-hidden hover:!overflow-y-auto max-h-80">
            @forelse ($sessions as $session)
                <x-ui.device-session-item :session="$session" />
            @empty
                <p class="text-sm text-center text-muted-foreground">لا توجد جلسات نشطة حالياً.</p>
            @endforelse
        </div>
    </div>
</div>

@push('models')
    <div x-data x-init="$store.model.init({{ $errors->has('password') ? 'true' : 'false' }})">
        <div x-show="$store.model.on" x-cloak
            @click.self="$store.model.close()"
            class="fixed z-50 inset-0 backdrop-blur-[2px] bg-accent-foreground/[0.04] flex items-center justify-center">
            <form action="{{ route('client.sessions.destroy') }}" method="POST" class="sm:w-[80%] md:w-1/2 w-full"
                x-show="$store.model.on" x-cloak
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">
                @csrf
                @method('DELETE')
                <div class="bg-card p-4 rounded-md shadow flex flex-col gap-4">
                    <h3 class="text-lg font-medium">تأكيد تسجيل الخروج من الجلسات</h3>
                    <p class="text-sm text-muted-foreground">
                        لتسجيل الخروج من جميع الجلسات النشطة، يرجى إدخال كلمة المرور الخاصة بك لتأكيد هويتك.
                    </p>
                    <div>
                        <x-forms.input-password name="password" required aria-required="كلمة السر مطلوبة" id="password_confirm" label="كلمة المرور"
                            placeholder="أدخل كلمة المرور" class="w-full" />
                        @error('password')
                            <p class="text-sm text-destructive mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex justify-end gap-2 mt-2">
                        <button type="submit" class="badget-green badget-80 hover:badget-70 px-2.5 py-1.5 rounded-md">
                            تسجيل الخروج من الجميع
                        </button>
                        <button type="reset" @click="$store.model.close()"
                            class="badget-red badget-80 hover:badget-70 px-2.5 py-1.5 rounded-md">
                            إلغاء
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endpush
