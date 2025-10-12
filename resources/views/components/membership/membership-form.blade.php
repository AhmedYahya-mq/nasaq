<section class="bg-gradient-to-b from-background to-muted/30">
    <div class="container mx-auto max-w-2xl px-4">
        <div class="mt-16 bg-card border border-border shadow-2xl shadow-primary/10 rounded-3xl overflow-hidden">
            <div class="p-8 md:p-10 bg-gradient-to-r from-primary/5 to-accent/5 border-b border-border text-center">
                <h2 class="text-xl md:text-2xl font-bold text-foreground">{{ __('memberships.form_header.title') }}</h2>
                <p class="text-muted-foreground mt-3 text-base max-w-md mx-auto">
                    {{ __('memberships.form_header.subtitle') }}
                </p>
            </div>
            <!-- جسم الفورم -->
            <form action="{{ route('client.membership.request', ['application' => $application]) }}" method="POST" enctype="multipart/form-data" class="p-8 md:p-10">
                @csrf
                <div class="space-y-10">
                    <!-- المجموعة الأولى: البيانات الشخصية -->
                    <fieldset class="space-y-6">
                        <legend class="text-lg font-semibold text-foreground pb-3 border-b-2 border-primary/20 w-full">
                            {{ __('memberships.personal_info.title') }}
                        </legend>
                        <x-forms.input name="name" :value="$user->name" :label="__('memberships.personal_info.full_name')" required />
                        <x-forms.input name="email" type="email" :value="$user->email" :label="__('memberships.personal_info.email')" required />
                        <x-forms.tel-input name="phone" :value="$user->phone" :label="__('memberships.personal_info.phone')" placeholder="05xxxxxxxx"
                            required />
                        <x-forms.input name="national_id" :value="old('national_id')" :label="__('memberships.personal_info.id_number')" required />
                    </fieldset>

                    <!-- المجموعة الثانية: المعلومات المهنية -->
                    <fieldset class="space-y-6">
                        <legend class="text-lg font-semibold text-foreground pb-3 border-b-2 border-primary/20 w-full">
                            {{ __('memberships.professional_info.title') }}
                        </legend>
                        <x-forms.select id="employment_status" name="employment_status" :value="old('employment_status', $user->employment_status->value ?? '')"
                            label="الحالة الوظيفية" :options="\App\Enums\EmploymentStatus::toKeyValueArray()" />
                        <x-forms.input name="job_title" :value="$user->job_title" :label="__('memberships.professional_info.job_title')" required />
                        <x-forms.input name="current_employer" :value="old('current_employer', $application->current_employer)" :label="__('memberships.professional_info.workplace')" />
                        <x-forms.input name="scfhs_number" :value="old('scfhs_number', $application->scfhs_number)" :label="__('memberships.professional_info.scfhs_number')" required />
                    </fieldset>

                    <!-- المجموعة الثالثة: إثبات التسجيل (التصميم النهائي) -->
                    <fieldset>
                        <x-forms.file-upload name="file" :title="__('memberships.proof.title')" :subtitle="__('memberships.proof.upload_subtitle')"
                             maxFiles="5" multiple='true' required />
                        @error('file')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </fieldset>

                </div>

                <!-- زر الإرسال -->
                <div class="pt-10 mt-10 border-t border-border">
                    <button type="submit"
                        class="w-full bg-primary text-primary-foreground py-4 text-xl rounded-xl font-bold shadow-lg shadow-primary/30 hover:bg-primary/90 transition-all duration-300 transform hover:scale-[1.01] focus:outline-none focus:ring-4 focus:ring-primary/30 flex items-center justify-center gap-3">
                        <span>{{ __('memberships.submit_button') }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 rtl:-scale-x-100" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
