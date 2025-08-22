import 'swiper/css/effect-creative';
import { Autoplay, EffectCreative } from 'swiper/modules';

export default () => {
    const swiperEl = document.querySelector('.mySwiper6');
    if (!swiperEl) return;
    Object.assign(swiperEl, {
        // slidesPerView: 3,
        loop: true,
        modules: [EffectCreative,Autoplay],
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        speed: 1000,
        centeredSlides: true,
        grabCursor: true,
        effect: "creative",
        creativeEffect: {
            prev: {
                shadow: true,
                origin: "left center",
                translate: ["-5%", 0, -200],
                rotate: [0, 100, 0],
            },
            next: {
                origin: "right center",
                translate: ["5%", 0, -200],
                rotate: [0, -100, 0],
            },
        },
    });

    // الآن نشغل السلايدر
    swiperEl.initialize();
};
