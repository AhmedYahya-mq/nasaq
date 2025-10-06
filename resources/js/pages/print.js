import html2canvas from 'html2canvas';

document.addEventListener('alpine:init', function () {
    Alpine.data('printInit', printInit);
});

function printInit() {
    return {
        async downloadTransparent() {
            const card = this.$refs.card;
            if (!card) return;

            // حفظ الأنماط الأصلية لعناصر البطاقة
            const originalStyles = [];

            // استبدال الألوان من نوع oklch أو color() بألوان آمنة مؤقتًا
            card.querySelectorAll('*').forEach((el, index) => {
                const style = getComputedStyle(el);
                const color = style.color || '';
                const bg = style.backgroundColor || '';

                if (color.includes('oklch') || color.includes('color(')) {
                    originalStyles[index] = { el, prop: 'color', value: el.style.color };
                    el.style.color = '#000'; // لون آمن مؤقتًا
                }

                if (bg.includes('oklch') || bg.includes('color(')) {
                    originalStyles[index] = { el, prop: 'backgroundColor', value: el.style.backgroundColor };
                    el.style.backgroundColor = '#fff';
                }
            });

            // تأخير بسيط لضمان اكتمال التغييرات
            setTimeout(async () => {
                try {
                    const canvas = await html2canvas(card, {
                        backgroundColor: null,
                        scale: 2,
                        useCORS: true
                    });

                    const link = document.createElement('a');
                    link.download = 'membership-card.png';
                    link.href = canvas.toDataURL('image/png');
                    link.click();
                } catch (error) {
                    console.error('html2canvas failed:', error);
                    alert('فشل تحميل الصورة. تحقق من الألوان أو الصور الخارجية.');
                } finally {
                    // إعادة الألوان الأصلية
                    originalStyles.forEach((s) => {
                        if (s && s.el && s.prop) s.el.style[s.prop] = s.value;
                    });
                }
            }, 100);
        }
    };
}
