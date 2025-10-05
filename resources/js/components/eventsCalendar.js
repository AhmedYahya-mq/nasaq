export default function eventsCalendar(events, trans, startDate, endDate) {
    return {
        startDate: new Date(startDate),
        endDate: new Date(endDate),
        currentStartDate: null,
        currentEndDate: null,
        weekDays: [],
        dayNames: trans.dayNames,
        monthNames: trans.monthNames,
        weekTitle: '',
        selectedDate: null,
        selectedEvents: [],
        showModal: false,
        modalTitle: '',
        isPrevDisabled: false,
        isNextDisabled: false,
        trans: { no_events: trans.no_events, events_for: trans.events_for },

        init() {
            // ابدأ من تاريخ اليوم أو startDate إذا اليوم خارج النطاق
            let today = new Date();
            if (today < this.startDate) today = new Date(this.startDate);
            if (today > this.endDate) today = new Date(this.endDate);
            this.setWeek(today);
        },

        setWeek(date) {
            // بداية الأسبوع (الأحد)
            let day = date.getDay();
            let startOfWeek = new Date(date);
            startOfWeek.setDate(date.getDate() - day);

            // إذا بداية الأسبوع قبل startDate، عدلها
            if (startOfWeek < this.startDate) startOfWeek = new Date(this.startDate);

            // احسب أيام الأسبوع (7 أيام أو حتى نهاية النطاق)
            this.weekDays = [];
            for (let i = 0; i < 7; i++) {
                let d = new Date(startOfWeek);
                d.setDate(startOfWeek.getDate() + i);
                if (d > this.endDate) break;
                let iso = d.toISOString().split('T')[0];
                let eventsCount = events.filter(e => e.iso_date === iso).length;
                this.weekDays.push({
                    date: d,
                    iso: iso,
                    dayName: this.dayNames[d.getDay()],
                    month: d.getMonth(),
                    year: d.getFullYear(),
                    eventsCount: eventsCount
                });
            }

            // التاريخ الكامل لأول وآخر يوم
            this.currentStartDate = this.weekDays.length ? this.weekDays[0].iso : null;
            this.currentEndDate = this.weekDays.length ? this.weekDays[this.weekDays.length - 1].iso : null;

            // عنوان الأسبوع: الشهر الحالي + السنة لأول يوم
            if (this.weekDays.length) {
                let first = this.weekDays[0];
                this.weekTitle = `${this.monthNames[first.month]} ${first.year}`;
            } else {
                this.weekTitle = '';
            }

            // تعطيل الأزرار إذا وصل للنهاية أو البداية
            this.isPrevDisabled = (this.weekDays.length && this.weekDays[0].iso === this.startDate.toISOString().split('T')[0]);
            this.isNextDisabled = (this.weekDays.length && this.weekDays[this.weekDays.length - 1].iso === this.endDate.toISOString().split('T')[0]);
        },

        prev() {
            if (this.isPrevDisabled) return;
            let firstDay = new Date(this.weekDays[0].date);
            firstDay.setDate(firstDay.getDate() - 7);
            if (firstDay < this.startDate) firstDay = new Date(this.startDate);
            this.setWeek(firstDay);
        },
        next() {
            if (this.isNextDisabled) return;
            let lastDay = new Date(this.weekDays[this.weekDays.length - 1].date);
            lastDay.setDate(lastDay.getDate() + 1);
            if (lastDay > this.endDate) return;
            this.setWeek(lastDay);
        },
        openDay(day) {
            this.selectedDate = day.date;
            this.modalTitle = `${this.trans.events_for} ${day.dayName}, ${day.date.getDate()} ${this.monthNames[day.month]}`;
            this.selectedEvents = events.filter(e => e.iso_date === day.iso);
            this.showModal = true;
        },
        isSelected(day) {
            return this.showModal && this.selectedDate && day.date.toISOString() === this.selectedDate.toISOString();
        }
    }
}

