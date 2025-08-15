@props(['classMenu'=>"", 'class'=>"inline-block"])
<div x-data="dropdown" class="{{ $class }}">
    <!-- الزرار -->
    <div x-ref="button" @click="toggle()" class="cursor-pointer">
        {{ $trigger ?? 'Toggle' }}
    </div>

    <!-- القائمة -->
    <div x-ref="menu"
        x-show="open"
        @click.away="close()"
        class="{{ $classMenu }}"
        style="display: none;">
        {{ $slot}}
    </div>
</div>

<script>

</script>
