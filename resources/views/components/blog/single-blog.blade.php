<article id="single-blog" class="py-16 md:py-24 bg-card" role="article" aria-label="{{ $blog->title }}">
    <div class="container mx-auto max-w-4xl px-4 space-y-10">

        {{-- عنوان المقال --}}
        <h1 class="text-3xl md:text-4xl font-bold mb-2 text-primary">
            {{ $blog->title }}
        </h1>

        {{-- الكاتب والتاريخ --}}
        @if(isset($author) && isset($created_at))
        <p class="text-sm text-muted-foreground mb-6">
            {{ __('blog.by') }} <span class="font-medium">{{ $author }}</span>
            | <time datetime="{{ $created_at }}">{{ $created_at }}</time>
        </p>
        @endif

        {{-- الصور --}}
        <div
            class="relative w-full h-auto aspect-[16/9] bg-card dark:bg-card-dark rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-shadow duration-300 group">
            <img src="{{ $photo->url }}"
                alt="{{ $blog->title }} - {{ $blog->excerpt ?? '' }}"
                class="object-cover min-w-lg max-h-md w-full h-full scale-100 group-hover:scale-105 transition-transform duration-300"
                loading="lazy">
        </div>


        {{-- محتوى المقال --}}
        <div class="prose max-w-full">
            {!! $blog->content !!}
        </div>

        {{-- نهاية المقال: مشاركة مبتكرة --}}
        <div
            class="mt-12 p-8 bg-gradient-to-r from-primary/20 to-primary/10 rounded-2xl border border-primary/30 shadow-lg text-center space-y-4">

            {{-- رسالة تشجيعية --}}
            <p class="text-lg md:text-xl font-semibold text-primary mb-4">
                {{ __('blog.share_message') }}
            </p>

            {{-- أزرار المشاركة --}}
            <div class="flex justify-center gap-4 flex-wrap">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" target="_blank"
                    rel="noopener noreferrer"
                    class="flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-xl hover:scale-105 hover:bg-blue-700 transition transform">
                    <x-ui.icon name="facebook" class="size-5 text-white" />
                    {{ __('blog.facebook') }}
                </a>
                <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ $blog->title }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="flex items-center gap-2 bg-blue-400 text-white px-6 py-3 rounded-xl hover:scale-105 hover:bg-blue-500 transition transform">
                    <x-ui.icon name="x" class="size-5 text-white" />
                    {{ __('blog.twitter') }}
                </a>
                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ url()->current() }}" target="_blank"
                    rel="noopener noreferrer"
                    class="flex items-center gap-2 bg-blue-700 text-white px-6 py-3 rounded-xl hover:scale-105 hover:bg-blue-800 transition transform">
                    <x-ui.icon name="linkedin" class="size-5 text-white" />
                    {{ __('blog.linkedin') }}
                </a>
            </div>

            {{-- نص إضافي --}}
            <p class="text-sm text-muted-foreground mt-4">
                {{ __('blog.share_note') }}
            </p>
        </div>

    </div>
</article>
