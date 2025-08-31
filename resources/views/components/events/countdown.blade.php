@props([
    'date' => now()->addDays(5)->format('Y-m-d H:i:s'), // وقت الفعالية المستهدف
])

<div
    x-data="countdownComponent('{{ $date }}')"
    x-init="init()"
    class="flex justify-center md:justify-start gap-3"
>
    <template x-for="(val, label) in timeParts" :key="label">
        <div class="flex flex-col items-center">
            <span
                x-text="val"
                class="text-2xl md:text-3xl font-bold text-primary bg-primary/10 px-4 py-2 rounded-xl shadow-sm border border-primary/20"
            ></span>
            <span class="text-xs text-muted-foreground mt-1" x-text="label"></span>
        </div>
    </template>
</div>

<script>
    function countdownComponent(targetDate) {
        return {
            target: new Date(targetDate),
            days: 0, hours: 0, minutes: 0, seconds: 0,
            timeParts: {},

            init() {
                this.update();
                setInterval(() => this.update(), 1000);
            },

            update() {
                const now = new Date().getTime();
                const distance = this.target - now;

                if (distance <= 0) {
                    this.days = this.hours = this.minutes = this.seconds = 0;
                } else {
                    this.days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    this.hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    this.minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    this.seconds = Math.floor((distance % (1000 * 60)) / 1000);
                }

                // Fetch localized labels from a global object or Laravel's translation service
                // Note: The actual implementation in JavaScript might vary depending on your setup.
                // This example assumes you have a way to expose translations to Alpine.js.
                const daysLabel = '{{ __('events.countdown.days') }}';
                const hoursLabel = '{{ __('events.countdown.hours') }}';
                const minutesLabel = '{{ __('events.countdown.minutes') }}';
                const secondsLabel = '{{ __('events.countdown.seconds') }}';

                this.timeParts = {
                    [daysLabel]: this.days,
                    [hoursLabel]: this.hours,
                    [minutesLabel]: this.minutes,
                    [secondsLabel]: this.seconds,
                };
            }
        }
    }
</script>
