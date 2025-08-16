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


window.Alpine = Alpine;
Alpine.plugin(focus);

// تسجيل الـ Stores
document.addEventListener('alpine:init', () => {
    registerThemeStore(Alpine);
    registerMenuStore(Alpine);
    Alpine.data('dropdown', dropdown);
    Alpine.data('hover', hover);
    loading();
    buttonToggleMenu();
});
Alpine.start();


