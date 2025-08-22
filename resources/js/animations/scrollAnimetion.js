import { stagger, text, onScroll, utils, animate, createTimer, svg } from 'animejs';
import { getTranslateX } from '../utils/getTranslate';
const [container] = utils.$('.scroll-container');
const debug = false;

/**
 * دالة موحدة لإنميشن الأرقام
 */
export function counterAnimation() {
    const $counters = utils.$('.counter');
    if (!$counters.length) return;

    $counters.forEach($el => {
        const duration = $el.dataset.counterEnd || 0;
        const easing = $el.dataset.easing || 'easeInOutQuad';
        createTimer({
            duration,
            easing,
            targets: $el,
            playbackRate: duration / 1000,
            frameRate: 120,
            onUpdate: self => {
                $el.innerHTML = Math.floor(self.iterationCurrentTime);
            },
            autoplay: onScroll({
                target: $el,
                axis: 'y',
                offset: $el,
                container,
                debug,
            })
        });
    });
}

/**
 * دالة موحدة لإنميشن النصوص
 * @param {string} selector - selector لكل العناصر المراد أنميشنها
 * @param {'lines' | 'words'} type - نوع الانقسام
 */
export function scrollAnimationText(selector, type = 'lines') {
    const elements = document.querySelectorAll(selector);
    if (!elements.length) return;

    elements.forEach(el => {
        const duration = parseInt(el.dataset.duration) || 1000;
        const delayStep = parseInt(el.dataset.delay) || 100;
        const easing = el.dataset.easing || 'easeInOutQuad';

        const splitOptions = type === 'lines' ? { lines: { wrap: 'clip' } } : { words: { wrap: 'clip' } };
        text.split(el, splitOptions).addEffect((parts) => animate(parts[type], {
            y: [
                { to: ['100%', '0%'] }
            ],
            duration,
            delay: stagger(delayStep),
            easing,
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
 * دالة لرسم خطوط SVG بالتسلسل
 * @param {string} selector - selector لكل خطوط SVG المراد أنميشنها
 * @param {number} duration - مدة رسم كل خط بالمللي ثانية
 * @param {number} delayStep - تأخير متسلسل لكل خط بالمللي ثانية
 */
export function drawSvgLines(selector, duration = 1000, delayStep = 500) {
    const targets = svg.createDrawable(selector);
    if (!targets.length) return;

    // رسم كل خط بالتسلسل
    targets.forEach(el => {
        animate(el, {
            duration,
            delay: stagger(delayStep),
            easing: 'easeInOutSine',
            draw: ['0 0', '0 1'],
            loop: false,
            autoplay: onScroll({
                target: el.parentNode,
                axis: 'y',
                offset: el.scrollTop,
                container,
                enter: 'bottom-=150 top-=120',
                leave: 'top bottom',
                debug,
            })
        });
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
        animate(el, {
            opacity: [0, 1],
            translateX: [getTranslateX(el) + 'px', '0px'],
            duration: duration,
            delay: stagger(delayStep),
            easing: 'easeInOutQuad',
            autoplay: onScroll({
                target: el.parentNode,
                axis: 'y',
                offset: el.scrollTop,
                container,
                enter: 'bottom-=150 top',
                leave: 'top bottom',
                debug,
            })
        });
    });

}


/**
 * تصدير دالة افتراضية لتشغيل كل الانميشن
 */
export default () => {
    scrollAnimationText('.text-animetion', 'lines');       // للعنوانين أو النصوص الكبيرة
    scrollAnimationText('.text-normal-animation', 'lines'); // للنصوص العادية
    animateCardsOnScroll();

};
