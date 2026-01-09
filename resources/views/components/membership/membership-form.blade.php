<section class="bg-background py-5">
    <div class="container mx-auto max-w-2xl px-4">
        <div class="rounded-2xl border border-border bg-card shadow-xl overflow-hidden">

            <!-- رأس بسيط وواضح -->
            <div class="p-8 md:p-10 border-b border-border text-center">
                <h2 class="text-2xl md:text-3xl font-bold text-foreground">{{ __('memberships.form_header.title') }}</h2>
                <p class="text-muted-foreground mt-3 text-base leading-relaxed">
                    {{ __('memberships.form_header.subtitle') }}
                </p>
            </div>

            <!-- جسم الفورم -->
            <form action="{{ route('client.membership.request.store', ['application' => $application]) }}" method="POST"
                enctype="multipart/form-data" class="p-6 md:p-10">
                @csrf

                {{-- تنبيه مختصر في أعلى الفورم عند وجود أخطاء --}}
                @if ($errors->any())
                    <div class="mb-6 rounded-xl border p-4 text-red-500">
                        <p class="font-semibold">{{ $errors->first() }}</p>
                        <p class="text-sm text-red-700 mt-1">{{ __('يرجى مراجعة الحقول أدناه.') }}</p>
                    </div>
                @endif



                <div class="space-y-10">
                    <!-- المجموعة الأولى: البيانات الشخصية -->
                    <fieldset class="space-y-6 rounded-xl border border-border p-5 md:p-6">
                        <legend class="text-base md:text-lg font-semibold text-foreground pb-2 w-full">
                            {{ __('memberships.personal_info.title') }}
                        </legend>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <x-forms.input name="name" :value="$user->name" :label="__('memberships.personal_info.full_name')" required />
                            <x-forms.input name="email" type="email" :value="$user->email" :label="__('memberships.personal_info.email')" required />
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <x-forms.tel-input name="phone" :value="$user->phone" :label="__('memberships.personal_info.phone')"
                                placeholder="05xxxxxxxx" required />
                            <x-forms.input name="national_id" :value="old('national_id')" :label="__('memberships.personal_info.id_number')" required />
                        </div>
                    </fieldset>

                    <!-- المجموعة الثانية: المعلومات المهنية -->
                    <fieldset class="space-y-6 rounded-xl border border-border p-5 md:p-6">
                        <legend class="text-base md:text-lg font-semibold text-foreground pb-2 w-full">
                            {{ __('memberships.professional_info.title') }}
                        </legend>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <x-forms.select id="employment_status" name="employment_status" :value="old('employment_status', $user->employment_status->value ?? '')"
                                :label="__('memberships.professional_info.status')" :options="\App\Enums\EmploymentStatus::toKeyValueArray()" />
                            <x-forms.input name="job_title" :value="$user->job_title" :label="__('memberships.professional_info.job_title')" required />
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <x-forms.input name="current_employer" :value="old('current_employer', $application->current_employer)" :label="__('memberships.professional_info.workplace')" />
                            <x-forms.input name="scfhs_number" :value="old('scfhs_number', $application->scfhs_number)" :label="__('memberships.professional_info.scfhs_number')" required />
                        </div>
                    </fieldset>

                    <!-- المجموعة الثالثة: إثبات التسجيل (التصميم النهائي) -->
                    <fieldset class="rounded-xl border border-dashed border-border bg-muted/20 p-5 md:p-6">
                        <x-forms.file-upload name="file" :title="__('memberships.proof.title')" :subtitle="__('memberships.proof.upload_subtitle')" maxFiles="5"
                            multiple='true' required />
                        @error('file')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                        @foreach ($errors->get('file.*') as $messages)
                            @foreach ($messages as $message)
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @endforeach
                        @endforeach
                    </fieldset>
                </div>

                <!-- زر الإرسال -->
                <div class="pt-10 mt-10 border-t border-border/80">
                    <button id="submitButton" type="submit"
                        class="group w-full rounded-xl bg-primary text-primary-foreground py-4 text-lg md:text-xl font-semibold shadow-lg= duration-200 hover:bg-primary/90 active:translate-y-[1px] focus:outline-none focus:ring-4 focus:ring-primary/30">
                        <span class="inline-flex items-center justify-center gap-3 text-white">
                            <span data-label>{{ __('memberships.submit_button') }}</span>
                            <svg data-icon xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6 rtl:-scale-x-100 transition-transform duration-200 group-hover:translate-x-0.5"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
