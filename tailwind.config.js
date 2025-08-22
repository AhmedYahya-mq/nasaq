/** @type {import('tailwindcss').Config} */
const plugin = require('tailwindcss/plugin');

module.exports = {
    darkMode: ['class'],
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Rubik', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                rubik: ['Rubik', 'sans-serif'],
            },
            colors: {
                background: 'var(--background)',
                foreground: 'var(--foreground)',
                card: {
                    DEFAULT: 'var(--card)',
                    foreground: 'var(--card-foreground)',
                },
                popover: {
                    DEFAULT: 'var(--popover)',
                    foreground: 'var(--popover-foreground)',
                },
                primary: {
                    DEFAULT: 'var(--primary)',
                    foreground: 'var(--primary-foreground)',
                },
                secondary: {
                    DEFAULT: 'var(--secondary)',
                    foreground: 'var(--secondary-foreground)',
                },
                muted: {
                    DEFAULT: 'var(--muted)',
                    foreground: 'var(--muted-foreground)',
                },
                accent: {
                    DEFAULT: 'var(--accent)',
                    foreground: 'var(--accent-foreground)',
                },
                destructive: {
                    DEFAULT: 'var(--destructive)',
                    foreground: 'var(--destructive-foreground)',
                },
                border: 'var(--border)',
                input: 'var(--input)',
                ring: 'var(--ring)',
            },
            borderRadius: {
                lg: 'var(--radius)',
                md: 'calc(var(--radius) - 2px)',
                sm: 'calc(var(--radius) - 4px)',
            },
        },
    },
    plugins: [
        plugin(function ({ addUtilities, matchUtilities, theme }) {

            // ================================
            // Base scrollbar
            // ================================
            addUtilities({
                '.scrollbar': {
                    'overflow-y': 'auto',
                    '--scrollbar-track-radius': '0px',
                    '--scrollbar-track-border': '0px',
                    '--scrollbar-thumb-radius': '8px',
                    '--scrollbar-thumb-border': '1px',
                    '--scrollbar-thumb-width': '5px',
                    '--scrollbar-thumb-color': 'var(--primary)',
                    '--scrollbar-track-color': 'var(--muted)',
                    '--scrollbar-thumb-hover-color': 'var(--accent)',
                }
            });

            // ================================
            // Colors
            // ================================
            const colorValues = {
                ...Object.entries(theme('colors')).reduce((acc, [name, value]) => {
                    if (typeof value === 'string') acc[name] = value;
                    else if (value && typeof value === 'object') acc[name] = value[500] || value.DEFAULT;
                    return acc;
                }, {})
            };

            matchUtilities({
                'scrollbar-track': (value) => ({ '--scrollbar-track-color': value }),
                'scrollbar-thumb': (value) => ({ '--scrollbar-thumb-color': value }),
                'scrollbar-thumb-hover': (value) => ({ '--scrollbar-thumb-hover-color': value }),

            }, { values: colorValues, supportsNegativeValues: false, type: 'color' });

            // ================================
            // Dimensions, border, radius (arbitrary values)
            // ================================
            matchUtilities({
                'scrollbar-thumb-w': (value) => ({ '--scrollbar-thumb-width': value }),
                'scrollbar-thumb-border': (value) => ({ '--scrollbar-thumb-border': value }),
                'scrollbar-thumb-radius': (value) => ({ '--scrollbar-thumb-radius': value }),
                'scrollbar-track-radius': (value) => ({ '--scrollbar-track-radius': value }),
                'scrollbar-track-border': (value) => ({ '--scrollbar-track-border': value }),
            }, { supportsNegativeValues: false, type: 'any' });

            // ================================
            // Badget example (من الكود السابق)
            // ================================
            addUtilities({
                '.badget': {
                    '--badget-percent': '84%',
                    '--badget-color': 'var(--primary)',
                    'background-color': 'color-mix(in srgb, var(--background) var(--badget-percent), var(--badget-color))',
                    'color': 'var(--badget-color)',
                }
            });

            const percentValues = { '10': '10', '20': '20', '30': '30', '40': '40', '50': '50', '60': '60', '70': '70', '80': '80', '90': '90' };
            matchUtilities({
                'badget': (value) => ({
                    '--badget-percent': `${value}%`,
                    'background-color': 'color-mix(in srgb, var(--background) var(--badget-percent,84%), var(--badget-color, var(--primary)))',
                    'color': 'var(--badget-color, var(--primary))',
                }),
            }, { values: percentValues, type: 'number' });

        }),
    ],
};
