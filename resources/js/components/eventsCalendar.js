/**
 * مكون تقويم الفعاليات لـ Alpine.js.
 *
 * هذا المكون يعرض تقويمًا شهريًا ويتيح للمستخدم التنقل بين الشهور
 * وعرض الفعاليات المسجلة في كل يوم.
 *
 * @param {Array} initialEvents - مصفوفة الفعاليات الأولية التي يتم تمريرها من Blade.
 * @param {Object} translations - كائن يحتوي على النصوص المترجمة من Blade.
 * @returns {Object} - كائن Alpine.js الذي يحتوي على الحالة والسلوك.
 */
export default function eventsCalendar(initialEvents = [], translations = {}) {
    return {
        // --- الحالة (State) ---
        month: new Date().getMonth(),
        year: new Date().getFullYear(),
        daysInMonth: [],
        blankdays: [],
        events: initialEvents,
        selectedDate: null,
        selectedEvents: [],
        showModal: false,
        modalTitle: '',

        // استخدام الترجمات الممررة أو قيم إنجليزية افتراضية كبديل
        dayNames: translations.dayNames || ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
        monthNames: translations.monthNames || ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        trans: translations, // الاحتفاظ بالكائن الكامل للوصول إلى نصوص أخرى

        // --- السلوك (Methods) ---

        /**
         * دالة التهيئة، يتم استدعاؤها عند تحميل المكون عبر x-init.
         */
        init() {
            this.calculateDays();
        },

        /**
         * تحسب عدد الأيام في الشهر الحالي والأيام الفارغة في بدايته.
         */
        calculateDays() {
            const firstDayOfMonth = new Date(this.year, this.month, 1).getDay();
            const daysInCurrentMonth = new Date(this.year, this.month + 1, 0).getDate();

            this.blankdays = Array.from({ length: firstDayOfMonth }, (_, i) => i + 1);
            this.daysInMonth = Array.from({ length: daysInCurrentMonth }, (_, i) => i + 1);
        },

        /**
         * ينتقل إلى الشهر السابق ويعيد حساب الأيام.
         */
        prev() {
            if (this.month === 0) {
                this.month = 11;
                this.year--;
            } else {
                this.month--;
            }
            this.calculateDays();
        },

        /**
         * ينتقل إلى الشهر التالي ويعيد حساب الأيام.
         */
        next() {
            if (this.month === 11) {
                this.month = 0;
                this.year++;
            } else {
                this.month++;
            }
            this.calculateDays();
        },

        /**
         * يبحث عن الفعاليات الخاصة بيوم معين.
         */
        eventsForDate(date) {
            const checkDate = new Date(Date.UTC(this.year, this.month, date));
            const isoDate = checkDate.toISOString().split('T')[0];
            return this.events.filter(e => e.iso_date === isoDate);
        },

        /**
         * يفتح النافذة المنبثقة ويعرض فعاليات اليوم المحدد.
         */
        openDay(date) {
            this.selectedDate = date;
            const fullDate = new Date(this.year, this.month, date);

            this.modalTitle = `${this.trans.events_for || 'Events for'} ${this.dayNames[fullDate.getDay()]}, ${date} ${this.monthNames[this.month]}`;
            this.selectedEvents = this.eventsForDate(date);
            this.showModal = true;
        },

        /**
         * يتحقق مما إذا كان اليوم الحالي هو اليوم المحدد (لتطبيق التنسيق الخاص).
         */
        isSelected(date) {
            return this.showModal && this.selectedDate === date;
        }
    };
}
