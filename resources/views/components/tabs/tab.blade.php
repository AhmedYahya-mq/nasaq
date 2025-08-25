@props(['id', 'delay' => '200ms'])

<div x-show="activeTab === '{{ $id }}'"
     x-cloak
     class="tab-content">
    {{ $slot }}
</div>
