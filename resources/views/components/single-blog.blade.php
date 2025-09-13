@props([
    'title' => __('blog.default_title'),
    'author' => __('blog.default_author'),
    'created_at' => now()->format('d M, Y'),
    'content' => __('blog.default_content'),
    'images' => [
        [
            'image' => 'seminar-1.webp',
            'caption' => __('blog.default_image_caption')
        ]
    ],
])

<section id="single-blog" class="py-16 md:py-24 bg-card">
    <div class="container mx-auto max-w-4xl px-4 space-y-10">

        {{-- عنوان المقال --}}
        <h2 class="text-3xl md:text-4xl font-bold mb-2 text-primary">
            {!! $title !!}
        </h2>

        {{-- الكاتب والتاريخ --}}
        <p class="text-sm text-muted-foreground mb-6">
            {{ __('blog.by') }} <span class="font-medium">{{ $author }}</span> | {{ $created_at }}
        </p>

        {{-- الصور --}}
        @if(!empty($images))
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($images as $img)
                    @if(isset($img['image']))
                        <div class="relative w-full h-auto bg-card rounded-lg overflow-hidden shadow-lg">
                            <img src="{{ asset('images/' . $img['image']) }}" alt="{{ $title }}" class="object-cover w-full h-64 md:h-72">
                            {{-- وصف صغير تحت الصورة --}}
                            @if(isset($img['caption']))
                                <div class="p-3 bg-card/90 text-muted-foreground text-sm font-medium text-center">
                                    {{ $img['caption'] }}
                                </div>
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
        @endif

        {{-- محتوى المقال --}}
        <div class="prose max-w-full text-justify text-muted-foreground">
            {!! $content !!}
        </div>

        {{-- نهاية المقال: مشاركة مبتكرة --}}
        <div class="mt-12 p-8 bg-gradient-to-r from-primary/20 to-primary/10 rounded-2xl border border-primary/30 shadow-lg text-center space-y-4">

            {{-- رسالة تشجيعية --}}
            <p class="text-lg md:text-xl font-semibold text-primary mb-4">
                {{ __('blog.share_message') }}
            </p>

            {{-- أزرار المشاركة --}}
            <div class="flex justify-center gap-4 flex-wrap">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" target="_blank"
                    class="flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-xl hover:scale-105 hover:bg-blue-700 transition transform">
                    <x-ui.icon name="facebook" class="size-5 text-white" />
                    {{ __('blog.facebook') }}
                </a>
                <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ $title }}" target="_blank"
                    class="flex items-center gap-2 bg-blue-400 text-white px-6 py-3 rounded-xl hover:scale-105 hover:bg-blue-500 transition transform">
                    <x-ui.icon name="x" class="size-5 text-white" />
                    {{ __('blog.twitter') }}
                </a>
                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ url()->current() }}" target="_blank"
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
</section>
