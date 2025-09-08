<x-layouts.guest-layout title="المدونة">
  <x-single-blog
    :title="__('blog.article2_title')"
    :author="__('blog.article2_author')"
    :created_at="now()->format('d M, Y')"
    :content="__('blog.article2_content')"
    :images="[
        ['image' => 'seminar-1.webp', 'caption' => __('blog.article2_caption1')],
        ['image' => 'seminar.webp', 'caption' => __('blog.article2_caption2')]
    ]"
/>

</x-layouts.guest-layout>
