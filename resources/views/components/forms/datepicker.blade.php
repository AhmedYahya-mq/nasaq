<div class="w-full" x-data="datepicker('{{ $value ?? '' }}')" x-init="init()" x-cloak>
    <x-forms.input
    type="text"
    value="{{ $value ?? '' }}"
    readonly
    x-ref="input"
    label="{{ $label ?? 'اختر التاريخ' }}"
    x-model="selectedDate"
    @click="toggle()"
    placeholder="اختر التاريخ"
    class="!cursor-pointer"
    icon="calendar" iconPosition="trailing"/>
    <!-- التقويم المنبثق -->
    <div x-ref="calendar" x-show="open" x-transition:enter="transition transform ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition transform ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95" @click.away="open = false"
        class="bg-card rounded-md shadow-lg p-3 z-10 absolute max-h-72 overflow-auto">
        <!-- رأس التقويم -->
        <div class="flex items-center justify-between mb-2 ">
            <button @click="prev()" class="p-1 px-3 hover:bg-accent/30 rounded ">&lt;</button>
            <button @click="toggleView()" class="px-2 py-1 rounded hover:bg-accent/30 font-medium">
                <span x-text="monthNames[month]" x-show="viewMode === 'day'"></span>
                <span x-show="viewMode === 'day'"> - </span>
                <span x-text="year"></span>
            </button>
            <button @click="next()" class="p-1 px-3 hover:bg-accent/20 rounded">&gt;</button>
        </div>

        <!-- اختيار السنة (year list) -->
        <div class="grid grid-cols-4 gap-1 mb-2" x-show="viewMode === 'year'">
            <template x-for="y in yearsToShow()" :key="y">
                <div @click="selectYear(y)" class="p-2 rounded cursor-pointer hover:bg-accent/30 text-center"
                    :class="y === year ? 'bg-primary text-white' : ''" x-text="y"></div>
            </template>
        </div>

        <!-- اختيار الشهر (monthYear mode) -->
        <div class="grid grid-cols-3 gap-1 mb-2" x-show="viewMode === 'monthYear'">
            <template x-for="(m, idx) in monthNames" :key="idx">
                <div @click="selectMonth(idx)" class="p-2 rounded cursor-pointer hover:bg-accent/30 text-center"
                    :class="idx === month ? 'bg-primary text-white' : ''" x-text="m"></div>
            </template>
        </div>

        <!-- شبكة الأيام -->
        <div class="grid grid-cols-7 gap-1 text-center" x-show="viewMode === 'day'">
            <template x-for="day in daysInMonth()" :key="day">
                <div @click="selectDate(day)" class="p-2 rounded hover:bg-accent/30 cursor-pointer"
                    :class="isSelected(day) ? 'bg-primary text-white' : ''" x-text="day"></div>
            </template>
        </div>
    </div>
</div>
