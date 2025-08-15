import './bootstrap';
import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';

// استيراد الـ Stores
import loading from './components/loading';
import registerThemeStore from './stores/theme';

// استيراد الـ Modules
import dropdown from './components/dropdown';
import hover from './components/hover';


window.Alpine = Alpine;
Alpine.plugin(focus);

// تسجيل الـ Stores
document.addEventListener('alpine:init', () => {
    registerThemeStore(Alpine);
    Alpine.data('dropdown', dropdown);
    Alpine.data('hover', hover);
    loading();
});
Alpine.start();


