@props(['title', 'items'])

<div>
    <h4 class="font-semibold mb-3">{{ $title }}</h4>
    <ul class="space-y-2">
        @foreach($items as $item)
            <li>
                <a href="{{ $item['link'] ?? '#' }}" class="transition-colors duration-200 hover:text-primary-foreground">
                    {{ $item['text'] }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
