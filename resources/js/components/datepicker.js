import { createPopper } from '@popperjs/core';
window.createPopper = createPopper;

export default function datepicker(defaultDate = null) {
    return {
        open: false,
        selectedDate: '',
        month: new Date().getMonth(),
        year: new Date().getFullYear(),
        viewMode: 'day', // day, monthYear, year
        monthNames: ['يناير','فبراير','مارس','أبريل','مايو','يونيو','يوليو','أغسطس','سبتمبر','أكتوبر','نوفمبر','ديسمبر'],
        popper: null,
        yearStart: new Date().getFullYear() - 6, // بداية عرض السنوات

        init() {
            let d = this.parseDate(defaultDate);

            if (!d || isNaN(d.getTime())) {
                return;
            }

            this.selectedDate = this.formatDate(d);
            this.month = d.getMonth();
            this.year = d.getFullYear();
        },

        // يحاول يفهم أي صيغة تاريخ
        parseDate(input) {
            if (!input) return null;

            // لو جاي بصيغة "DD/MM/YYYY"
            if (/^\d{1,2}\/\d{1,2}\/\d{4}$/.test(input)) {
                const [day, month, year] = input.split('/').map(Number);
                return new Date(year, month - 1, day);
            }

            // جرب صيغة جافاسكربت العادية
            const d = new Date(input);
            if (!isNaN(d.getTime())) return d;

            return null;
        },

        formatDate(date) {
            // صيغة موحدة: YYYY-MM-DD
            return [
                date.getFullYear(),
                String(date.getMonth() + 1).padStart(2, '0'),
                String(date.getDate()).padStart(2, '0')
            ].join('-');
        },

        toggle() {
            this.open = !this.open;
            this.$nextTick(() => {
                if (!this.popper) {
                    this.popper = createPopper(this.$refs.input, this.$refs.calendar, {
                        placement: 'bottom-start',
                        modifiers: [{ name: 'offset', options: { offset: [0, 5] } }],
                    });
                } else {
                    this.popper.update();
                }
            });
        },

        toggleView() {
            if(this.viewMode === 'day') this.viewMode = 'monthYear';
            else if(this.viewMode === 'monthYear') this.viewMode = 'year';
            else this.viewMode = 'day';
        },

        prev() {
            if(this.viewMode === 'day') {
                if(this.month === 0) { this.month = 11; this.year--; }
                else this.month--;
            } else if(this.viewMode === 'monthYear') {
                this.year--;
            } else if(this.viewMode === 'year') {
                this.yearStart -= 12;
            }
        },

        next() {
            if(this.viewMode === 'day') {
                if(this.month === 11) { this.month = 0; this.year++; }
                else this.month++;
            } else if(this.viewMode === 'monthYear') {
                this.year++;
            } else if(this.viewMode === 'year') {
                this.yearStart += 12;
            }
        },

        daysInMonth() {
            return new Date(this.year, this.month + 1, 0).getDate();
        },

        selectDate(day) {
            let d = new Date(this.year, this.month, day);
            this.selectedDate = this.formatDate(d);
            this.open = false;
        },

        selectMonth(idx) {
            this.month = idx;
            this.viewMode = 'day';
        },

        selectYear(y) {
            this.year = y;
            this.viewMode = 'monthYear';
        },

        isSelected(day) {
            if(!this.selectedDate) return false;
            const [y, m, d] = this.selectedDate.split('-').map(Number);
            return y === this.year && m === this.month + 1 && d === day;
        },

        yearsToShow() {
            return Array.from({length: 12}, (_, i) => this.yearStart + i);
        }
    }
}
