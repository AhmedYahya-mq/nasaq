@props([
    'name',
    'label',
    'required' => false,
    'value' => null,
    'options' => [], // ['value' => 'Label']
    'placeholder' => __('Select an option'),
    'disabled' => false,
    'isSearch' => false, // لتفعيل البحث
    'multiple' => false, // لتفعيل الاختيار المتعدد
])

<div class="w-full" x-data="selectComponent({
    multiple: {{ $multiple ? 'true' : 'false' }},
    isSearch: {{ $isSearch ? 'true' : 'false' }},
    value: @js($value),
    options: @js($options)
})" x-modelable="selected" {{ $attributes->merge(['class' => '']) }}>

    {{-- الحقل --}}
    <div class="relative">
        <x-forms.input @click="open = !open" :id="$name" :label="$label" :readonly="true" :name="$multiple ? '' : $name"
            :required="$required" x-bind:value="displayLabel" :placeholder="$placeholder" icon="arrow-up-down"
            iconPosition="trailing" />

        {{-- القائمة --}}
        <div x-show="open" @click.away="open=false" x-transition
            class="absolute z-[100] mt-1 w-full bg-background border rounded-md shadow max-h-60 scrollbar">

            <template x-if="isSearch">
                <div class="p-2 border-b sticky top-0 bg-background z-10">
                    <input type="text" x-model="search" placeholder="{{ __('Search...') }}"
                        class="w-full px-2 py-1 text-sm border rounded focus:outline-none focus:ring-1 focus:ring-primary" />
                </div>
            </template>

            <ul>
                <template x-for="[val, label] in Object.entries(filteredOptions)" :key="val">
                    <li @click="toggleOption(val)"
                        class="px-4 py-1.5 flex justify-between items-center cursor-pointer hover:bg-primary/35 transition"
                        :class="{ 'bg-primary/25': isSelected(val) }">
                        <span x-text="label"></span>
                        <span x-show="isSelected(val)">
                            <x-ui.icon name="check" class="size-4 text-primary" />
                        </span>
                    </li>
                </template>
            </ul>

        </div>
    </div>

    {{-- hidden inputs للفورم --}}
    <template x-if="multiple">
        <div>
            <template x-for="val in selected" :key="val">
                <input type="hidden" :name="'{{ $name }}[]'" :value="val" />
            </template>
        </div>
    </template>

    <template x-if="!multiple">
        <input type="hidden" :name="'{{ $name }}'" :value="selected" />
    </template>
</div>
