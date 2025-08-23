
<section class="relative isolate overflow-hidden bg-card py-24 sm:py-32">

    {{-- نفس الخلفية الزخرفية المستخدمة في الهيرو --}}
    <div class="absolute -top-52 left-1/2 -z-10 -translate-x-1/2 transform-gpu blur-3xl sm:top-[-28rem] sm:ml-16 sm:translate-x-0 sm:transform-gpu" aria-hidden="true">
        <div class="aspect-[1097/845] w-[68.5625rem] bg-gradient-to-tr from-primary/50 to-primary/20 opacity-50"
             style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
        </div>
    </div>

    {{-- المحتوى النصي بنفس طريقة الهيرو --}}
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-4xl text-center">

            {{-- العنوان الرئيسي للقسم --}}
            <h2 class="text-4xl font-extrabold tracking-tight text-foreground sm:text-6xl leading-tight">
                {{ __('whoweare.title_part1') }} <span class="text-primary">{{ __('whoweare.title_part2') }}</span>
            </h2>

            {{-- النص التعريفي --}}
            <p class="mt-6 text-lg leading-8 text-muted-foreground">
                {{ __('whoweare.content') }}
            </p>

        </div>
    </div>
</section>
