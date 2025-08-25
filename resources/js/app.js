import './bootstrap';
import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';

// استيراد الـ Stores
import registerThemeStore from './stores/theme';
import registerMenuStore from './stores/menu';

// استيراد الـ Modules
import loading from './components/loading';
import dropdown from './components/dropdown';
import hover from './components/hover';
import buttonToggleMenu from './components/button-toggle-menu';
import { register } from 'swiper/element';
import swiperSlide from './animations/swiperSlide';
import importing from './scrollAnimtionImport';
import datepicker from './components/datepicker';
import phoneInput from './components/tel';

window.Alpine = Alpine;
Alpine.plugin(focus);

// تسجيل الـ Stores
document.addEventListener('alpine:init', () => {
    registerThemeStore(Alpine);
    registerMenuStore(Alpine);
    Alpine.data('dropdown', dropdown);
    Alpine.data('hover', hover);
    Alpine.data('datepicker', datepicker);
    Alpine.data('phoneInput', phoneInput);
    loading();
    buttonToggleMenu();

});
Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    register();
    swiperSlide();
    importing();
});
