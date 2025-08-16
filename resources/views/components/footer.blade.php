<footer class="bg-card border-t border-primary mt-16  py-10 pb-3 w-full flex flex-col">
    {{-- حاوية الأعمدة ممتدة بعرض الشاشة --}}
    <div class="container">
        <div class="w-full mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-8 text-sm">

            {{-- العمود الأول: الشعار وأيقونات التواصل --}}
            <div class="col-span-1">
                <a href="/" class="inline-flex items-center gap-2 mb-4">
                    <img src="{{ asset('favicon.ico') }}" alt="Nasaq" class="h-10 w-10">
                    <h3 class="text-lg font-semibold">{{ __('messages.nsasq') }}</h3>
                </a>

                <div class="flex space-x-4">
                    {{-- مربعات فارغة للأيقونات --}}
                    <a href="https://facebook.com" target="_blank" aria-label="Facebook"
                        class="w-6 h-6 border flex items-center justify-center rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-4 h-4">
                            <path
                                d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.879v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.772-1.63 1.562V12h2.773l-.443 2.892h-2.33v6.987C18.343 21.128 22 16.991 22 12z" />
                        </svg>
                    </a>
                    {{-- Instagram --}}
                    <a href="https://instagram.com" target="_blank" aria-label="Instagram"
                        class="w-6 h-6 border flex items-center justify-center rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-4 h-4">
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 1.17.054 1.97.24 2.427.415a4.92 4.92 0 011.792 1.169 4.918 4.918 0 011.169 1.792c.175.456.361 1.257.415 2.427.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.054 1.17-.24 1.97-.415 2.427a4.902 4.902 0 01-1.169 1.792 4.91 4.91 0 01-1.792 1.169c-.456.175-1.257.361-2.427.415-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.17-.054-1.97-.24-2.427-.415a4.91 4.91 0 01-1.792-1.169 4.906 4.906 0 01-1.169-1.792c-.175-.456-.361-1.257-.415-2.427C2.175 15.584 2.163 15.204 2.163 12s.012-3.584.07-4.85c.054-1.17.24-1.97.415-2.427a4.92 4.92 0 011.169-1.792 4.918 4.918 0 011.792-1.169c.456-.175 1.257-.361 2.427-.415C8.416 2.175 8.796 2.163 12 2.163zm0-2.163C8.741 0 8.332.013 7.052.072 5.78.131 4.876.322 4.1.554a6.919 6.919 0 00-2.51 1.03A6.918 6.918 0 00.554 4.1c-.232.777-.423 1.681-.482 2.953C0 8.332 0 8.741 0 12c0 3.259.013 3.668.072 4.948.059 1.272.25 2.176.482 2.953a6.918 6.918 0 001.03 2.51 6.916 6.916 0 002.51 1.03c.777.232 1.681.423 2.953.482 1.28.059 1.689.072 4.948.072s3.668-.013 4.948-.072c1.272-.059 2.176-.25 2.953-.482a6.919 6.919 0 002.51-1.03 6.918 6.918 0 001.03-2.51c.232-.777.423-1.681.482-2.953.059-1.28.072-1.689.072-4.948s-.013-3.668-.072-4.948c-.059-1.272-.25-2.176-.482-2.953a6.918 6.918 0 00-1.03-2.51 6.919 6.919 0 00-2.51-1.03c-.777-.232-1.681-.423-2.953-.482C15.668.013 15.259 0 12 0z" />
                            <circle cx="12" cy="12" r="3.6" />
                        </svg>
                    </a>

                    {{-- LinkedIn --}}
                    <a href="https://linkedin.com" target="_blank" aria-label="LinkedIn"
                        class="w-6 h-6 border flex items-center justify-center rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-4 h-4">
                            <path
                                d="M4.98 3.5C4.98 4.88 3.88 6 2.5 6S0 4.88 0 3.5 1.12 1 2.5 1 4.98 2.12 4.98 3.5zM.24 8h4.5v16h-4.5V8zm7.5 0h4.32v2.337h.06c.6-1.137 2.067-2.338 4.26-2.338 4.56 0 5.4 3 5.4 6.9V24h-4.5v-7.563c0-1.8-.033-4.113-2.508-4.113-2.508 0-2.892 1.958-2.892 3.983V24h-4.5V8z" />
                        </svg>
                    </a>

                    {{-- X (Twitter سابقًا) --}}
                    <a href="https://x.com" target="_blank" aria-label="X"
                        class="w-6 h-6 border flex items-center justify-center rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-4 h-4">
                            <path
                                d="M24 4.557a9.94 9.94 0 01-2.828.775 4.93 4.93 0 002.165-2.724 9.864 9.864 0 01-3.127 1.195 4.916 4.916 0 00-8.384 4.482 13.944 13.944 0 01-10.125-5.138 4.902 4.902 0 001.523 6.573 4.902 4.902 0 01-2.228-.616v.062a4.916 4.916 0 003.946 4.827 4.902 4.902 0 01-2.224.085 4.918 4.918 0 004.593 3.417A9.867 9.867 0 010 19.54a13.94 13.94 0 007.548 2.212c9.142 0 14.307-7.721 13.995-14.646A9.936 9.936 0 0024 4.557z" />
                        </svg>
                    </a>

                    {{-- YouTube --}}
                    <a href="https://youtube.com" target="_blank" aria-label="YouTube"
                        class="w-6 h-6 border flex items-center justify-center rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-4 h-4">
                            <path
                                d="M19.615 3.184c-1.18-.492-5.905-.492-5.905-.492s-4.724 0-5.905.492C6.14 3.662 5.5 4.297 5.5 5.214v13.572c0 .917.64 1.552 1.305 2.03 1.18.492 5.905.492 5.905.492s4.724 0 5.905-.492c.664-.478 1.305-1.113 1.305-2.03V5.214c0-.917-.64-1.552-1.305-2.03zM9.75 16.5v-9l7.5 4.5-7.5 4.5z" />
                        </svg>
                    </a>
                </div>
            </div>

            {{-- باقي الأعمدة باستخدام مكون FooterColumn --}}
            <x-footer-column :title="__('footer.features')" :items="[
                ['text' => __('footer.design')],
                ['text' => __('footer.scale')],
                ['text' => __('footer.responsive_design')],
            ]" />

            <x-footer-column :title="__('footer.resources')" :items="[
                ['text' => __('footer.get_started')],
                ['text' => __('footer.marketplace')],
                ['text' => __('footer.browse_templates')],
            ]" />

            <x-footer-column :title="__('footer.support')" :items="[
                ['text' => __('footer.help')],
                ['text' => __('footer.community')],
                ['text' => __('footer.emergency')],
            ]" />

            <x-footer-column :title="__('footer.enterprise')" :items="[
                ['text' => __('footer.overview'), 'link' => '#'],
                ['text' => __('footer.collaboration')],
                ['text' => __('footer.customers')],
            ]" />

        </div>
    </div>

    {{-- الحقوق   --}}
    <div class="mt-10 w-full text-center text-xs">
        &copy; {{ date('Y') }} {{ __('footer.copyright') }}
        <a href="/" class="font-semibold hover:text-primary">{{ __('messages.nsasq') }}</a>
    </div>
</footer>
