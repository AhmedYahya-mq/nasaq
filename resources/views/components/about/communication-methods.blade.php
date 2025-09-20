@php
    // جلب إعدادات التواصل من ملف الترجمة باستخدام المسار الجديد
    $methodsConfig = __('about.contact_section.methods');

    // تعريف الأيقونات والألوان لكل طريقة تواصل
    $contactMethods = config('app.social_media', []);

@endphp

<section class="py-16 sm:py-24 bg-gradient-to-b from-background via-background/80 to-muted/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- العنوان الرئيسي --}}
        <div class="text-center mb-12">
            <h2 class="text-xl sm:text-2xl lg:text-2xl font-extrabold text-foreground tracking-tight">
                {{ __('about.contact_section.main_title') }}
            </h2>
            <p class="mt-4 max-w-xl mx-auto text-lg text-muted-foreground">
                {{ __('about.contact_section.subtitle') }}
            </p>
        </div>

        {{-- حاوية القسمين: النموذج والروابط --}}
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-12">

            {{-- القسم الأيسر: نموذج المراسلة --}}
            <div class="lg:col-span-3 bg-card p-6 sm:p-8 rounded-2xl border border-border shadow-lg"
                x-data="contactForm()">
                <h3 class="text-xl font-bold text-foreground mb-6">{{ __('about.contact_section.form.title') }}</h3>

                <div x-show="success" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6"
                    x-transition>
                    <p class="font-bold">{{ __('about.contact_section.form.success_title') }}</p>
                    <p>{{ __('about.contact_section.form.success_message') }}</p>
                </div>

                <form @submit.prevent="submitForm" x-show="!success" class="space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <x-forms.input name="name" id="contact-name" :label="__('about.contact_section.form.name')" :placeholder="__('about.contact_section.form.name_placeholder')"
                            x-model="formData.name" icon="user" required />
                        <x-forms.input type="email" name="email" id="contact-email" :label="__('about.contact_section.form.email')"
                            :placeholder="__('about.contact_section.form.email_placeholder')" x-model="formData.email" icon="mail" required />
                    </div>

                    <x-forms.tel-input name="phone" id="contact-phone" :label="__('about.contact_section.form.phone')" :placeholder="__('about.contact_section.form.phone_placeholder')"
                        x-model="formData.phone" />

                    <x-forms.input name="subject" id="contact-subject" :label="__('about.contact_section.form.subject')" :placeholder="__('about.contact_section.form.subject_placeholder')"
                        x-model="formData.subject" icon="annotation" required />

                    <x-forms.text-area name="message" id="contact-message" :label="__('about.contact_section.form.message')" :placeholder="__('about.contact_section.form.message_placeholder')"
                        x-model="formData.message" rows="5" required />

                    <div>
                        <button type="submit" :disabled="loading"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary disabled:bg-muted disabled:cursor-not-allowed">
                            <span x-show="!loading">{{ __('about.contact_section.form.send_button') }}</span>
                            <span x-show="loading" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                {{ __('about.contact_section.form.loading') }}
                            </span>
                        </button>
                    </div>
                </form>
            </div>

            {{-- القسم الأيمن: روابط التواصل --}}
            <div class="lg:col-span-2">
                <h3 class="text-xl font-bold text-foreground mb-6">{{ __('about.contact_section.quick_links.title') }}
                </h3>
                <div class="space-y-4">
                    @foreach ($contactMethods as $method)
                        @if (env('CONTACT_' . strtoupper($method['env_key'])))
                            <a href="{{ $method['url'] }}" target="_blank" rel="noopener noreferrer"
                                class="group flex items-center p-4 rounded-xl bg-card border border-border shadow-sm hover:shadow-lg hover:border-primary/50 transition-all duration-300 transform hover:-translate-y-1">
                                <div
                                    class="flex-shrink-0 w-12 h-12 rounded-lg {{ $method['bg_color'] }}  flex items-center justify-center transition-transform duration-300 group-hover:scale-110 group-hover:rotate-6">
                                    <x-ui.icon :name="$method['icon']" class="w-6 h-6 fill-white" fill="#fff" />
                                </div>
                                <div class="ms-4">
                                    <p class="text-lg font-semibold text-foreground">{{ $method['env_key'] }}</p>
                                    <p class="text-sm text-muted-foreground">
                                        {{ __('about.contact_section.quick_links.action_text') }}</p>
                                </div>
                                <div
                                    class="ms-auto text-muted-foreground/50 group-hover:text-primary transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- السكريبتات اللازمة للمكونات (لا تحتاج لتغيير) --}}
<script>
    if (typeof contactForm === 'undefined') {
        function contactForm() {
            return {
                formData: {
                    name: '',
                    email: '',
                    phone: '',
                    subject: '',
                    message: ''
                },
                loading: false,
                success: false,
                submitForm() {
                    this.loading = true;
                    console.log('Sending data:', this.formData);
                    setTimeout(() => {
                        this.loading = false;
                        this.success = true;
                        this.formData = {
                            name: '',
                            email: '',
                            phone: '',
                            subject: '',
                            message: ''
                        };
                        setTimeout(() => this.success = false, 5000);
                    }, 2000);
                }
            }
        }
    }
    if (typeof phoneInput === 'undefined') {
        function phoneInput() {
            return {
                isValid: true,
                error: ''
            }
        }
    }
</script>
