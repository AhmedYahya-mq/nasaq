export default function registerThemeStore(Alpine) {
    Alpine.store('theme', {
        value: localStorage.getItem('theme') || 'light',
        set(theme) {
            this.value = theme;
            localStorage.setItem('theme', theme);

            if (theme === 'system') {
                const isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                document.documentElement.classList[isDark ? 'add' : 'remove']('dark');
            } else {
                document.documentElement.classList[theme === 'dark' ? 'add' : 'remove']('dark');
            }
        },
        init() {
            if (this.value === 'system') {
                const isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                document.documentElement.classList[isDark ? 'add' : 'remove']('dark');
                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                    if (this.value === 'system') this.set('system');
                });
            } else {
                document.documentElement.classList[this.value === 'dark' ? 'add' : 'remove']('dark');
            }
        }
    });

    Alpine.store('theme').init();
}
