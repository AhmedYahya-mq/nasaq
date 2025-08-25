<div class="pb-14">
    <div class="p-4 flex flex-col gap-4">
        <div class="flex flex-col items-end gap-2">
            <div>
                <h6 class="text-[0.875rem] font-medium mb-1">
                    المصادقة الثائية (2FA)
                </h6>
                <p class="text-muted-foreground">
                    يمكنك تمكين المصادقة الثنائية (2FA) لتعزيز أمان حسابك. عند التمكين، ستحتاج إلى إدخال رمز تحقق إضافي
                    يتم إرساله إلى هاتفك المحمول عند تسجيل الدخول.
                </p>
            </div>
            <div class="w-full mb">
                <img src="{{ asset('images/qr.png') }}" width="120" height="120" alt="">
                <p class="text-muted-foreground text-sm my-2">
                    امسح رمز الاستجابة السريعة (QR) باستخدام تطبيق المصادقة الخاص بك (مثل Google Authenticator أو Authy)
                    لإعداد المصادقة الثنائية (2FA).
                </p>
                <x-forms.input name="code" id="code" label="رمز التحقق" placeholder="أدخل رمز التحقق المكون من 6 أرقام"
                    class="w-full" />
            </div>
            <div class="w-full flex flex-wrap justify-end gap-3.5" x-data>
                <button aria-label="Enable 2FA" @click="$dispatch('toggle-form', true)">
                    <span
                        class="text-sm text-white bg-primary px-3 py-1 rounded-md hover:bg-primary/80 transition-colors">
                        تمكين المصادقة الثنائية (2FA)
                    </span>
                </button>

                <button type="button" class="btn btn-outline-primary">
                    <span
                        class="text-sm text-white bg-primary px-3 py-1 rounded-md hover:bg-primary/80 transition-colors">
                        تنزيل ملف الاسترداد
                    </span>
                </button>

            </div>

        </div>
    </div>
</div>
@push('modals')
    <div x-data="{ show: false }" x-show="show" x-cloak @toggle-form.window="show = $event.detail"
        class="absolute top-0 z-50 w-dvw h-dvh backdrop-blur-[2px] bg-accent-foreground/[0.04] flex items-center justify-center">
        <form action="" class="sm:w-[80%] w-full"
            x-show="show" x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90"
        >
            <div class="bg-card p-4 rounded-md shadow flex flex-col gap-4">
                {{-- ادخل الباسورد من اجل اتمكين 2FA --}}
                <h3 class="text-lg font-medium">تمكين المصادقة الثنائية (2FA)</h3>
                <p class="text-sm text-muted-foreground">يرجى إدخال كلمة المرور الخاصة بك لتأكيد تمكين المصادقة الثنائية
                    (2FA).</p>
                <div>
                    <x-forms.input-password  name="current_password" id="current_password
                        " label="كلمة المرور الحالية" placeholder="أدخل كلمة المرور الحالية" class="w-full" />
                </div>
                <div class="flex justify-end gap-2 mt-2">
                    <button type="submit" class="badget-green badget-80 hover:badget-70 px-2.5 py-1.5 rounded-md">
                        تمكين
                    </button>
                    <button type="button" class="badget-red badget-80 hover:badget-70 px-2.5 py-1.5 rounded-md"
                        @click="show = false">
                        إلغاء
                    </button>
                </div>
            </div>

        </form>
    </div>
@endpush
