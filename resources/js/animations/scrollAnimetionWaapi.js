import { stagger, text, onScroll, utils, waapi } from 'animejs';
import { getTranslateX } from '../utils/getTranslate';

const [container] = utils.$('.scroll-container');
const debug = false;

/**
 * دالة موحدة لإنميشن النصوص باستخدام WAAPI
 * @param {string} selector - selector للعناصر
 * @param {'lines' | 'words'} type - نوع الانقسام
 */
export function scrollAnimationTextWaapi(selector, type = 'lines') {
    const elements = document.querySelectorAll(selector);
    if (!elements.length) return;

    elements.forEach(el => {
        const duration = parseInt(el.dataset.duration) || (type === 'lines' ? 1000 : 100);
        const delayStep = parseInt(el.dataset.delay) || (type === 'lines' ? 200 : 100);
        const easing = el.dataset.easing || 'ease-in-out';

        const splitOptions = type === 'lines' ? { lines: { wrap: 'clip' } } : { words: { wrap: 'clip' } };
        text.split(el, splitOptions).addEffect((parts) => waapi.animate(parts[type], {
            y: {
                from: '100%',
                to: '0%',
            },
            delay: stagger(delayStep),
            duration,
            ease: easing,
            loop: false,
            autoplay: onScroll({
                target: el.parentNode,
                axis: 'y',
                offset: el.scrollTop,
                container,
                debug,
            })
        }));
    });
}


/**
 * دالة لتطبيق انميشن البطاقات عند ظهورها في الشاشة
 * @param {string} selector - selector للبطاقات
 * @param {number} duration - مدة الانميشن لكل بطاقة (ms)
 * @param {number} delayStep - تأخير متسلسل لكل بطاقة (ms)
 */
export function animateCardsOnScroll(selector = '.box-card', duration = 500, delayStep = 100) {
    document.querySelectorAll(selector).forEach(el => {

        // إضافة انميشن للبطاقات
        waapi.animate(el, {
            opacity: [0, 1],
            translateX: [getTranslateX(el)+'px', '0px'],
            duration: duration,
            delay: stagger(delayStep),
            ease: 'ease-in-out',
            loop: false,
            autoplay: onScroll({
                target: el.parentNode,
                axis: 'y',
                offset: el.scrollTop,
                container,
                enter: 'bottom-=70 top',
                leave: 'top bottom',
                debug,
            })
        });
    });

}

/**
 * تصدير دوال افتراضية لتشغيل النصوص
 */
export default () => {
    scrollAnimationTextWaapi('.text-animetion', 'lines');       // للعناوين الكبيرة
    scrollAnimationTextWaapi('.text-normal-animation', 'lines'); // للنصوص العادية
    animateCardsOnScroll();

};
