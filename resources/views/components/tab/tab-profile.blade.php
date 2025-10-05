<div class="relative pb-14">
    <form x-data='profileForm(@json($user))' @submit.prevent='submit' x-ref="form" method="post">
        <div>
            <x-forms.input id="email" name="email" label="البريد الإلكتروني" type="email"
                placeholder="أدخل البريد الإلكتروني" class="w-full" icon="mail" x-model="form.email" />
            <template x-if="errors.email">
                <div class="text-sm text-destructive" x-text="errors.email"></div>
            </template>
            <div x-show="isVerificationRequired" class="mt-2 text-sm text-yellow-600 flex items-center gap-1">
                <span>لم يتم التحقق من بريدك الإلكتروني.</span>
                <button type="button"
                    class="underline text-primary hover:text-primary/80 font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary rounded "
                    @click="sendVerification" :disabled="loading">
                    <span x-show="!loading" x-text='textSendEmail'></span>
                    <span x-show="loading">جاري الإرسال...
                        <div
                            class="mx-1 animate-spin inline-block w-4 h-4 border-2 border-current border-t-transparent rounded-full ml-1">

                        </div>
                    </span>
                </button>
            </div>
            <div x-show='isSendEmail' class="text-sm text-green-600 mt-2">
                تم إرسال رابط التحقق إلى بريدك الإلكتروني.
            </div>
            <div x-show='isErrorSendEmail' class="text-sm text-destructive mt-2">
                حدث خطأ أثناء إرسال رابط التحقق. حاول مرة أخرى لاحقًا.
            </div>
        </div>
        <div class="@container flex flex-col gap-y-3.5">
            <div class="grid grid-cols-1 @md:grid-cols-2 gap-4">
                <div>
                    <x-forms.input id="first-name" name="name" label="الأسم" type="text" placeholder="أدخل الأسم"
                        class="w-full mb-3.5" icon="user" x-model="form.name" />
                    <template x-if="errors.name">
                        <div class="text-sm text-destructive" x-text="errors.name"></div>
                    </template>

                </div>
                <div>
                    <x-forms.tel-input id="phone" name="phone" label="رقم الجوال" x-model="form.phone"
                        value="{{ $user->phone }}" />
                    <template x-if="errors.phone">
                        <div class="text-sm text-destructive" x-text="errors.phone"></div>
                    </template>
                </div>
                <div>
                    <x-forms.input id="address" name="address" x-model="form.address" label="العنوان" type="text"
                        placeholder="أدخل العنوان" class="w-full" icon="location" />
                    <template x-if="errors.address">
                        <div class="text-sm text-destructive" x-text="errors.address"></div>
                    </template>
                </div>
                <div>
                    <x-forms.datepicker label="تاريخ الميلاد" id="birthday" x-init="$watch('selectedDate', value => form.birthday = value)"
                        value="{{ $user->birthday }}" name="birthday" />
                    <template x-if="errors.birthday">
                        <div class="text-sm text-destructive" x-text="errors.birthday"></div>
                    </template>
                </div>
            </div>
            <div>
                <x-forms.input id="job-title" name="job-title" x-model="form.job_title" label="المسمى الوظيفي"
                    type="text" placeholder="أكتب المسمى الوظيفي" class="w-full" icon="job" />
                <template x-if="errors.job_title">
                    <div class="text-sm text-destructive" x-text="errors.job_title"></div>
                </template>
            </div>
            <div>
                <x-forms.select id="employment_status" name="employment_status" x-model="form.employment_status"
                    label="الحالة الوظيفية" :options="\App\Enums\EmploymentStatus::toKeyValueArray()" />

                <template x-if="errors.employment_status">
                    <div class="text-sm text-destructive" x-text="errors.employment_status"></div>
                </template>
            </div>
            <div>
                <x-forms.text-area name="bio" x-model="form.bio" label="نبذه عنك" placeholder="تحدث عن نفسك" />
                <template x-if="errors.bio">
                    <div class="text-sm text-destructive" x-text="errors.bio"></div>
                </template>
            </div>
        </div>
        <div class="absolute bottom-0 rtl:left-5 ltr:right-5 flex items-center gap-3 rtl:flex-row-reverse">
            <div class="flex gap-3">
                <button :disabled="disabled"
                    class="flex rtl:flex-row-reverse items-center gap-1.5 badget badget-primary hover:badget-80 disabled:badget-primary/35 transition-colors py-2 px-3 rounded-md hover:bg-primary/60 cursor-pointer"
                    aria-label="تحديث">
                    {{-- اضهار علامة تحميل --}}
                    <span x-show="disabled" class="border-2 border-primary border-r-transparent inline-block rounded-full size-4 animate-spin"></span>
                    تحديث
                </button>
                <button type="button" :disabled="disabled" @click="reset"
                    class="badget badget-destructive hover:badget-70 disabled:badget-destructive/35 py-2 px-3 rounded-md transition-colors cursor-pointer"
                    aria-label="تحديث">

                    الغاء
                </button>
            </div>
            <div x-show="saved" x-transition class="text-sm text-green-600 font-medium">
                تم الحفظ!
            </div>
        </div>
    </form>
</div>
