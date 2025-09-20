@props(['name', 'class' => 'w-6 h-6'])

@if (view()->exists("components.icons.$name"))
    @include("components.icons.$name", ['class' => $class, 'attributes' => $attributes])
@else
    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="{{ $class }}">
        <path fill-rule="evenodd" clip-rule="evenodd"
            d="m6.72 5.66 11.62 11.62A8.25 8.25 0 0 0 6.72 5.66Zm10.56 12.68L5.66 6.72a8.25 8.25 0 0 0 11.62 11.62ZM5.105 5.106c3.807-3.808 9.98-3.808 13.788 0 3.808 3.807 3.808 9.98 0 13.788-3.807 3.808-9.98 3.808-13.788 0-3.808-3.807-3.808-9.98 0-13.788Z"/>
    </svg>
@endif
