@php
// جلب إعدادات التواصل من ملف الترجمة باستخدام المسار الجديد
$methodsConfig = __('about.contact_section.methods');

// تعريف الأيقونات والألوان لكل طريقة تواصل
$contactMethods = [
    ['name' => 'whatsapp', 'icon' => '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.894 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.886-.001 2.267.655 4.398 1.908 6.161l-1.217 4.439 4.555-1.193z"/></svg>', 'bg_color' => 'bg-[#25D366] hover:bg-[#128C7E]'],
    ['name' => 'email', 'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>', 'bg_color' => 'bg-red-500 hover:bg-red-600'],
    ['name' => 'twitter', 'icon' => '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>', 'bg_color' => 'bg-black hover:bg-gray-800'],
    ['name' => 'instagram', 'icon' => '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><defs><radialGradient id="instaGradient" r="150%" cx="30%" cy="107%"><stop stop-color="#fdf497" offset="0"/><stop stop-color="#fdf497" offset="0.05"/><stop stop-color="#fd5949" offset="0.45"/><stop stop-color="#d6249f" offset="0.6"/><stop stop-color="#285AEB" offset="0.9"/></radialGradient></defs><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.85s-.011 3.584-.069 4.85c-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07s-3.584-.012-4.85-.07c-3.252-.148-4.771-1.691-4.919-4.919-.058-1.265-.069-1.645-.069-4.85s.011-3.584.069-4.85c.149-3.225 1.664-4.771 4.919-4.919 1.266-.058 1.644-.07 4.85-.07zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948s.014 3.667.072 4.947c.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072s3.667-.014 4.947-.072c4.358-.2 6.78-2.618 6.98-6.98.059-1.281.073-1.689.073-4.948s-.014-3.667-.072-4.947c-.2-4.358-2.618-6.78-6.98-6.98-1.281-.059-1.689-.073-4.948-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.162 6.162 6.162 6.162-2.759 6.162-6.162-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4s1.791-4 4-4 4 1.79 4 4-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>', 'bg_color' => 'bg-gradient-to-br from-purple-500 via-pink-500 to-red-500'],
    ['name' => 'snapchat', 'icon' => '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm.09 19.49c-1.45 0-2.58-.5-3.5-1.48-.91-.99-.99-2.17-.99-3.87s.08-2.88.99-3.87c.92-.98 2.05-1.48 3.5-1.48 1.45 0 2.58.5 3.5 1.48.91.99.99 2.17.99 3.87s-.08 2.88-.99 3.87c-.92.98-2.05 1.48-3.5 1.48zm-2.04-3.87c0 1.11.05 1.8.15 2.16.1.36.3.63.59.82.29.19.65.28 1.07.28s.78-.09 1.07-.28c.29-.19.49-.46.59-.82.1-.36.15-1.05.15-2.16s-.05-1.8-.15-2.16c-.1-.36-.3-.63-.59-.82-.29-.19-.65-.28-1.07-.28s-.78.09-1.07-.28c-.29-.19-.49-.46-.59-.82-.1-.36-.15-1.05-.15-2.16z"/></svg>', 'bg_color' => 'bg-yellow-400 hover:bg-yellow-500 text-black'],
];

// إضافة الموقع الجغرافي فقط إذا كان مفعّلاً في ملف الترجمة
if (data_get($methodsConfig, 'location.enabled', false)) {
    $contactMethods[] = ['name' => 'location', 'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>', 'bg_color' => 'bg-green-500 hover:bg-green-600'];
}
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
            <div class="lg:col-span-3 bg-card p-6 sm:p-8 rounded-2xl border border-border shadow-lg" x-data="contactForm()">
                <h3 class="text-xl font-bold text-foreground mb-6">{{ __('about.contact_section.form.title') }}</h3>

                <div x-show="success" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6" x-transition>
                    <p class="font-bold">{{ __('about.contact_section.form.success_title') }}</p>
                    <p>{{ __('about.contact_section.form.success_message') }}</p>
                </div>

                <form @submit.prevent="submitForm" x-show="!success" class="space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <x-forms.input name="name" id="contact-name" :label="__('about.contact_section.form.name')" :placeholder="__('about.contact_section.form.name_placeholder')" x-model="formData.name" icon="user" required />
                        <x-forms.input type="email" name="email" id="contact-email" :label="__('about.contact_section.form.email')" :placeholder="__('about.contact_section.form.email_placeholder')" x-model="formData.email" icon="mail" required />
                    </div>

                    <x-forms.tel-input name="phone" id="contact-phone" :label="__('about.contact_section.form.phone')" :placeholder="__('about.contact_section.form.phone_placeholder')" x-model="formData.phone" />

                    <x-forms.input name="subject" id="contact-subject" :label="__('about.contact_section.form.subject')" :placeholder="__('about.contact_section.form.subject_placeholder')" x-model="formData.subject" icon="annotation" required />

                    <x-forms.text-area name="message" id="contact-message" :label="__('about.contact_section.form.message')" :placeholder="__('about.contact_section.form.message_placeholder')" x-model="formData.message" rows="5" required />

                    <div>
                        <button type="submit" :disabled="loading" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary disabled:bg-muted disabled:cursor-not-allowed">
                            <span x-show="!loading">{{ __('about.contact_section.form.send_button') }}</span>
                            <span x-show="loading" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                {{ __('about.contact_section.form.loading' ) }}
                            </span>
                        </button>
                    </div>
                </form>
            </div>

            {{-- القسم الأيمن: روابط التواصل --}}
            <div class="lg:col-span-2">
                <h3 class="text-xl font-bold text-foreground mb-6">{{ __('about.contact_section.quick_links.title') }}</h3>
                <div class="space-y-4">
                    @foreach ($contactMethods as $method)
                        @php $config = $methodsConfig[$method['name']]; @endphp
                        <a href="{{ $config['link'] }}" target="_blank" rel="noopener noreferrer"
                           class="group flex items-center p-4 rounded-xl bg-card border border-border shadow-sm hover:shadow-lg hover:border-primary/50 transition-all duration-300 transform hover:-translate-y-1">
                            <div class="flex-shrink-0 w-12 h-12 rounded-lg {{ $method['bg_color'] }} text-white flex items-center justify-center transition-transform duration-300 group-hover:scale-110 group-hover:rotate-6">
                                {!! $method['icon'] !!}
                            </div>
                            <div class="ms-4">
                                <p class="text-lg font-semibold text-foreground">{{ $config['title'] }}</p>
                                <p class="text-sm text-muted-foreground">{{ __('about.contact_section.quick_links.action_text') }}</p>
                            </div>
                            <div class="ms-auto text-muted-foreground/50 group-hover:text-primary transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                            </div>
                        </a>
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
                formData: { name: '', email: '', phone: '', subject: '', message: '' },
                loading: false,
                success: false,
                submitForm() {
                    this.loading = true;
                    console.log('Sending data:', this.formData);
                    setTimeout(() => {
                        this.loading = false;
                        this.success = true;
                        this.formData = { name: '', email: '', phone: '', subject: '', message: '' };
                        setTimeout(() => this.success = false, 5000);
                    }, 2000);
                }
            }
        }
    }
    if (typeof phoneInput === 'undefined') {
        function phoneInput() {
            return { isValid: true, error: '' }
        }
    }
</script>
