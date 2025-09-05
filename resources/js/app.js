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
import eventsCalendar from './components/eventsCalendar';
import countdown from './components/countdown';


// مكون رفع الصور  filepond
import * as FilePond from 'filepond';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';

// تسجيل مكون Swiper
register();

// تسجيل مكون العد التنازلي عالميًا
Alpine.data('countdown', countdown);

window.Alpine = Alpine;
Alpine.plugin(focus);


// تسجيل مكونات FilePond
window.FilePond = FilePond;
window.FilePondPluginImagePreview = FilePondPluginImagePreview;
window.FilePondPluginFileValidateType = FilePondPluginFileValidateType;
window.FilePondPluginFileValidateSize = FilePondPluginFileValidateSize;


// تسجيل الـ Stores
document.addEventListener('alpine:init', () => {
    registerThemeStore(Alpine);
    registerMenuStore(Alpine);
    Alpine.data('dropdown', dropdown);
    Alpine.data('hover', hover);
    Alpine.data('datepicker', datepicker);
    Alpine.data('phoneInput', phoneInput);
    Alpine.data('eventsCalendar', eventsCalendar);
    Alpine.data('countdown', countdown);
    loading();
    buttonToggleMenu();

});
Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    register();
    swiperSlide();
    importing();
});
