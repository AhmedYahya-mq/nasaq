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
        chart: {
          '1': 'var(--chart-1)',
          '2': 'var(--chart-2)',
          '3': 'var(--chart-3)',
          '4': 'var(--chart-4)',
          '5': 'var(--chart-5)',
        },
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
      // 1. الفئة الأساسية
      addUtilities({
        '.badget': {
          '--badget-percent': '84%',
          '--badget-color': 'var(--primary)',
          'background-color': 'color-mix(in srgb, var(--background) var(--badget-percent), var(--badget-color))',
          'color': 'var(--badget-color)',
        }
      });

      // 2. تحضير قيم الألوان
      const colorValues = {
        'red': "#ff0000",
        'green': "#00ff00",
        'blue': "#0000ff",
        'yellow': "#ffff00",
        'purple': "#800080",
        'pink': "#ff00ff",
        'orange': "#ffa500",
        'brown': "#a52a2a",
        'grey': "#808080",
        ...Object.entries(theme('colors')).reduce((acc, [name, value]) => {
          if (typeof value === 'string') {
            acc[name] = value;
          } else if (value && typeof value === 'object') {
            acc[name] = value[500] || value.DEFAULT;
          }
          return acc;
        }, {})
      };

      // 3. معالجة الألوان
      matchUtilities(
        {
          'badget': (value) => ({
            '--badget-color': value,
            'background-color': 'color-mix(in srgb, var(--background) var(--badget-percent,84%), var(--badget-color))',
            'color': 'var(--badget-color)',
          }),
        },
        {
          values: colorValues,
          supportsNegativeValues: false,
          type: 'color'
        }
      );

      // 4. معالجة النسب المئوية (بدعم التركيبات)
      matchUtilities(
        {
          'badget': (value) => ({
            '--badget-percent': `${value}%`,
            'background-color': 'color-mix(in srgb, var(--background) var(--badget-percent,84%), var(--badget-color, var(--primary)))',
            'color': 'var(--badget-color, var(--primary))',
          }),
        },
        {
          values: {
            '10': '10',
            '20': '20',
            '30': '30',
            '40': '40',
            '50': '50',
            '60': '60',
            '70': '70',
            '80': '80',
            '90': '90',
          },
          type: 'number'
        }
      );
    }),
  ],
};
