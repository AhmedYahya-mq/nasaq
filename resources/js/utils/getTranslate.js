
/**
 * تحدد قيمة translateX حسب حجم الشاشة واتجاه العنصر
 * @param {HTMLElement} el
 * @returns {number} قيمة translateX بالبكسل
 */
export function getTranslateX(el) {
    const baseValue = 40; // المسافة الأساسية
    if (window.innerWidth >= 768) {
        const dir = el.dataset.dirction;
        console.log(`Direction: ${dir}`);

        return dir === 'left' ? baseValue : -baseValue;
    } else {
        return document.documentElement.dir === 'rtl' ? -baseValue : baseValue;
    }
}
