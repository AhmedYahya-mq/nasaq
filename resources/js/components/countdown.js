/**
 * مكون العد التنازلي لـ Alpine.js.
 *
 * يعرض عدادًا تنازليًا لتاريخ ووقت مستهدف.
 *
 * @param {string} targetDate - التاريخ والوقت المستهدف بصيغة ISO (e.g., 'YYYY-MM-DD HH:mm:ss').
 * @param {Object} translations - كائن يحتوي على نصوص الترجمة (أيام، ساعات، دقائق، ثواني).
 * @returns {Object} - كائن Alpine.js الذي يحتوي على الحالة والسلوك.
 */
export default function countdown(targetDate, translations = {}) {
    return {
        // --- الحالة (State) ---
        target: new Date(targetDate),
        timeParts: {},
        interval: null, // لتخزين مؤقت الدالة setInterval

        // استخدام الترجمات الممررة أو قيم افتراضية
        labels: {
            days: translations.days || 'Days',
            hours: translations.hours || 'Hours',
            minutes: translations.minutes || 'Minutes',
            seconds: translations.seconds || 'Seconds',
        },

        // --- السلوك (Methods) ---

        /**
         * دالة التهيئة، يتم استدعاؤها عند تحميل المكون.
         */
        init() {
            this.update(); // التحديث الفوري عند التحميل
            this.interval = setInterval(() => this.update(), 1000); // ثم التحديث كل ثانية
        },

        /**
         * دالة يتم استدعاؤها عند تدمير المكون (عند إزالته من الصفحة).
         * تقوم بإيقاف الـ setInterval لمنع تسرب الذاكرة.
         */
        destroy() {
            clearInterval(this.interval);
        },

        /**
         * تقوم بتحديث قيم العد التنازلي.
         */
        update() {
            const now = new Date();
            const distance = this.target.getTime() - now.getTime();

            let days, hours, minutes, seconds;

            if (distance <= 0) {
                // إذا انتهى الوقت، أوقف العداد واجعل القيم صفرًا
                clearInterval(this.interval);
                days = hours = minutes = seconds = 0;
            } else {
                days = Math.floor(distance / (1000 * 60 * 60 * 24));
                hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                seconds = Math.floor((distance % (1000 * 60)) / 1000);
            }

            // تحديث الكائن الذي يتم عرضه في القالب
            // استخدام toLocaleString('ar-EG') لضمان عرض الأرقام بالصيغة العربية إذا أردت
            this.timeParts = {
                [this.labels.days]: String(days).padStart(2, '0'),
                [this.labels.hours]: String(hours).padStart(2, '0'),
                [this.labels.minutes]: String(minutes).padStart(2, '0'),
                [this.labels.seconds]: String(seconds).padStart(2, '0'),
            };
        }
    };
}
