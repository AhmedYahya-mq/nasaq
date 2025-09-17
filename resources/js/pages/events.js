import countdown from "@client/components/countdown";
import eventsCalendar from "@client/components/eventsCalendar";

document.addEventListener('alpine:init', () => {
    Alpine.data('countdown', countdown);
    Alpine.data('eventsCalendar', eventsCalendar);
});
